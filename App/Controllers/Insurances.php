<?php

namespace App\Controllers;

use App\Models\Insurance;
use \Core\View;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Config;

class Insurances  extends \Core\Controller
{

  protected $column_array = [
    'created_at',
    'name',
    'birth_date',
    'phone',
    'passport',
    'email',
    'date_from',
    'date_to',
    'number_of_days',
    'type',
  ];

  protected $order_array = ['asc', 'desc'];

  /**
   * Show the index page
   *
   * @return void
   */
  public function index()
  {

    if (isset($_GET['order'])) {
      if (in_array($_GET['order'] , $this->order_array)) {
        $order = $_GET['order'];
      }
    }

    if (isset($_GET['column'])) {
      if (in_array($_GET['column'] , $this->column_array)) {
        $column = $_GET['column'];
      }
    }

    if (isset($column) && isset($order)) {
      $data = Insurance::getAll($column, $order);
    } else {
      $data = Insurance::getAll();
    }

    // Convert the date format before displaying it to the user
    foreach ($data as $key => $value) {
      $data[$key] = $this->convertDate($value,  'Y-m-d', 'd-m-Y');
    }

    View::render('Insurances/index.php', [
      'view_title' => 'Sva osiguranja',
      'data' => $data
    ]);
  }

  /**
   * Show the show page
   *
   * @return void
   */
  public function show()
  {
    $id = $this->route_params['id'];

    $data = Insurance::getOne($id);

    // Convert the date format before displaying it to the user
    $data = $this->convertDate($data,  'Y-m-d', 'd-m-Y');

    View::render('Insurances/show.php', [
      'view_title' => 'Prikaz',
      'data' => $data
    ]);

  }


  public function usersTable()
  {

    if (isset($_GET['column'])) {
      if ($_GET['column'] == 'name') {
        $column = $_GET['column'];
      }
    }

    if (isset($_GET['order'])) {
      if ($_GET['order'] == 'asc' || $_GET['order'] == 'desc') {
        $order = $_GET['order'];
      }
    }

    if (isset($column) && isset($order)) {
      $data = Insurance::getAllNames($column, $order);
    } else {
      $data = Insurance::getAllNames();
    }

    View::render('Insurances/users-table.php', [
      'view_title' => 'Nosioci osiguranja',
      'data' => $data
    ]);
  }

  public function showUserTable()
  {
    $id = $this->route_params['id'];

    $data = Insurance::getOne($id);

    // Convert the date format before displaying it to the user
    $data = $this->convertDate($data,  'Y-m-d', 'd-m-Y');

    View::render('Insurances/show-user-table.php', [
      'view_title' => 'Nosioac osiguranja',
      'data' => $data
    ]);
  }


  


  /**
   * Show the create page
   *
   * @return void
   */
  public function create($data = [], $errors = [])
  {

    View::render('Insurances/create.php', [
      'view_title' => 'Insurances',
      'data' => $data,
      'errors' => $errors
    ]);
  }


  /**
   * Stores the form data
   *
   * @return void
   */
  public function store()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitButton'])) {

      $data = [];

      if (!empty($_POST)) {
        $data = $this->sanitizeFormData();
      }

      if (isset($data['people'])) {
        $data['lats_people_key'] = array_key_last($data['people']);
      }

//      echo '<pre>' . print_r($_POST, true) . '</pre>';
//      echo '<pre>' . print_r($data, true) . '</pre>';


      $start = strtotime($data['date_from']);
      $end = strtotime($data['date_to']);
      $diff_in_days = floor(($end - $start) / (60 * 60 * 24));
      if ($diff_in_days == 0) {
        $diff_in_days++;
      }
      $data['number_of_days'] = $diff_in_days;

//      echo '<pre>' . print_r($data, true) . '</pre>';

      // Validating the the form data
      $errors = $this->validateFormData($data);


      if (!empty($errors)) {
        $this->create($data, $errors);
      } else {

        // If the phone field is left blank it will be converted to null
        if (empty($data['phone'])) {
          $data['phone'] = null;
        }

        echo '<pre>' . print_r($data, true) . '</pre>';

        // Converting the dates before inserting them into the database
        $data = $this->convertDate($data, 'd-m-Y', 'Y-m-d');

        $latInsertedId = Insurance::insert($data);


        if (isset($latInsertedId)) {
          $this->createPDF($data, $latInsertedId);
        } else {
          header('Location: /insurances/create');
        }

      }


    } else {
      // This request is from the get method. Or the wrong button is clicked
      throw new \Exception('Somethig went wrong.');
    }

  }


  protected function sanitizeFormData()
  {
    $data = [];

    foreach ($_POST as $key => $value) {
      if (!is_array($value)) {

        if ($key == 'email') {
          $data[$key] = filter_var(strip_tags(trim($value)), FILTER_SANITIZE_EMAIL);

        } else {
          $data[$key] = filter_var(strip_tags(trim($value)), FILTER_SANITIZE_STRING);
        }

      }

      if (is_array($value)) {

        foreach ($value as $k => $v) {
          foreach ($v as $k2 => $v2) {
            $data[$key][$k][$k2] = filter_var(strip_tags(trim($v2)), FILTER_SANITIZE_STRING);
          }
        }

      }

    }
    return $data;
  }


  protected function validateFormData($data)
  {
    $errors = [];

    /*** Name ***/
    if (empty($data['name'])) {
      $errors['name'] = 'Polje je obavezno!';
    } else if (strlen($data['name']) > 128) {
      $errors['name'] = 'Ime ne sme bit duže od 128 karaktera!';
    }

    /*** Birth Date ***/
    if (empty($data['birth_date'])) {
      $errors['birth_date'] = 'Polje je obavezno!';
    } else if (!$this->validateDate($data['birth_date'])) {
      $errors['birth_date'] = 'Datum nije validan!';
    }

    /*** Phone ***/
    if (!empty($data['phone'])) {
      if (!is_numeric($data['phone'])) {
        $errors['phone'] = 'Broj telefona može da sadrži samo brojeve.';
      } else if (strlen($data['phone']) > 20) {
        $errors['phone'] = 'Broj telefona ne može da sadrži više od 20 karaktera!';
      }
    }

    /*** Passport ***/
    if (empty($data['passport'])) {
      $errors['passport'] = 'Polje je obavezno!';
    } else if (!is_numeric($data['passport'])) {
      $errors['passport'] = 'Broj pasoša može da sadrži samo brojeve.';
    } else if (strlen($data['passport']) > 20) {
      $errors['passport'] = 'Broj pasoša ne može biti duži od 20 karaktera.';
    }

    /*** Email ***/
    if (empty($data['email'])) {
      $errors['email'] = 'Polje je obavezno!';
    } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Email nije odgovarajućeg formata!';
    }

    /*** Date From***/
    if (empty($data['date_from'])) {
      $errors['date_from'] = 'Polje je obavezno!';
    } else if (!$this->validateDate($data['date_from'])) {
      $errors['date_from'] = 'Datum nije validan!';
    }

    /*** Date To***/
    if (empty($data['date_to'])) {
      $errors['date_to'] = 'Polje je obavezno!';
    } else if (!$this->validateDate($data['date_to'])) {
      $errors['date_to'] = 'Datum nije validan!';
    }

    if ($data['number_of_days'] < 0) {
      $errors['number_of_days'] =
        'Kraj putovanja ne može biti pre početka putovanja.';
    }

    /*** Insurance Type ***/
    if (empty($data['type'])) {
      $errors['type'] = 'Polje je obavezno!';
    } else if (!in_array($data['type'], [Insurance::SINGLE, Insurance::GROUP])) {
      $errors['type'] = 'Polje je nema odgovarajuću vrednost!';
    }

    /*** Additional People ***/
    if (!empty($data['people']) && $data['type'] == Insurance::GROUP) {

      foreach ($data['people'] as $key => $value) {
        /*** Name ***/
        if (empty($value['name'])) {
          $errors['people'][$key]['name'] = 'Polje je obavezno!';
        }
        /*** Birth Date ***/
        if (empty($value['birth_date'])) {
          $errors['people'][$key]['birth_date'] = 'Polje je obavezno!';
        } else if (!$this->validateDate($value['birth_date'])) {
          $errors['people'][$key]['birth_date'] = 'Datum nije odgovarajućeg formata!';
        }


        /*** Passport ***/
        if (empty($value['passport'])) {
          $errors['people'][$key]['passport'] = 'Polje je obavezno!';
        } else if (!is_numeric($value['passport'])) {
          $errors['people'][$key]['passport'] = 'Broj pasoša može da sadrži samo brojeve.';
        } else if (strlen($value['passport']) > 20) {
          $errors['people'][$key]['passport'] = 'Broj pasoša ne može biti duži od 20 karaktera.';
        }
      }

    }

    return $errors;
  }


  /**
   * Validating the date from the form
   *
   * @param $date
   * @return bool
   */
  protected function validateDate($date)
  {
    $date_array = explode('-', $date);
    if (count($date_array) == 3) {
      if (checkdate($date_array[1], $date_array[0], $date_array[2])) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  /**
   * @param array $formDate
   * @param string $convertFrom
   * @param string $convertTo
   * @return string
   */
  protected function convertDateFormat($formDate, $convertFrom, $convertTo)
  {
    $dt = \DateTime::createFromFormat($convertFrom, $formDate);
    $date = $dt->format($convertTo);
    return $date;
  }


  /**
   * Converts all dates from the $date array to the desired format:
   * e.g from 'd-m-Y' to 'Y-m-d' or backwards
   *
   * @param array $data
   * @param string $convertFrom
   * @param string $convertTo
   * @return array mixed
   */
  protected function convertDate($data, $convertFrom, $convertTo)
  {
    // Converting the dates before inserting them into the database
    $data['birth_date'] = $this->convertDateFormat($data['birth_date'], $convertFrom, $convertTo);
    $data['date_from'] = $this->convertDateFormat($data['date_from'], $convertFrom, $convertTo);
    $data['date_to'] = $this->convertDateFormat($data['date_to'], $convertFrom, $convertTo);
    if (isset($data['created_at'])) {
      $data['created_at'] = $this->convertDateFormat($data['created_at'], $convertFrom, $convertTo);
    }

    if (
      $data['type'] == Insurance::GROUP &&
      isset($data['people']) &&
      count($data['people']) > 0
    ) {
      foreach ($data['people'] as $key => $value) {
        $data['people'][$key]['birth_date'] = $this->convertDateFormat($value['birth_date'], $convertFrom, $convertTo);
      }
    }

    return $data;
  }



  protected function createPDF($data, $latInsertedId)
  {
    $data = $this->convertDate($data,  'Y-m-d', 'd-m-Y');

    if ($data['type'] == Insurance::GROUP) {
      $policy_type = 'Grupno ';
    } else {
      $policy_type = 'individalno';
    }

    $mpdf = new \Mpdf\Mpdf();

    $content = '<h1>Polisa Osiguranja</h1>';
    $content .= '<strong>Nosilac Polise: </strong>' . $data['name'] . '<br>';
    $content .= '<strong>Datum rođenja: </strong>' . $data['birth_date'] . '<br>';
    if (isset($data['phone'])) {
      $content .= '<strong>Telefon: </strong>' . $data['phone'] . '<br>';
    }
    $content .= '<strong>Broj pasoša: </strong>' . $data['passport'] . '<br>';
    $content .= '<strong>Email: </strong>' . $data['email'] . '<br>';
    $content .= '<strong>Datum polaska: </strong>' . $data['date_from'] . '<br>';
    $content .= '<strong>Datum dolaska: </strong>' . $data['date_to'] . '<br>';
    $content .= '<strong>Broj dana: </strong>' . $data['number_of_days'] . '<br>';
    $content .= '<strong>Tip polise osiguranja: </strong>' . $policy_type . '<br><br>';

    if (
      $data['type'] == Insurance::GROUP &&
      isset($data['people']) &&
      count($data['people']) > 0
    ) {
      $content .= '<h2>Dodatni osiguranici:</h2>';
      foreach ($data['people'] as $key => $value) {
        $content .= '<strong>Ime i prezime: </strong>' . $value['name'] . '<br>';
        $content .= '<strong>Datum rođenja: </strong>' . $value['birth_date'] . '<br>';
        $content .= '<strong>Broj pasoša: </strong>' . $value['passport'] . '<br><br>';
      }
    }

    // write PDF
    $mpdf->WriteHTML($content);

    // Output to a string
    $pdf = $mpdf->Output('', 'S');

    // Send the PDF through email
    $this->sendEmail($latInsertedId, $pdf, $data);

  }



  protected function sendEmail($latInsertedId, $pdf, $data)
  {
    echo 'Send EMAIL';

    $mail = new PHPMailer(true);

    try {
      //Server settings
      $mail->SMTPDebug = Config::SMTP_DEBUG;                    // Enable verbose debug output
      $mail->isSMTP();                                            // Send using SMTP
      $mail->Host       = Config::EMAIL_HOST;                    // Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = Config::EMAIL_USERNAME;                     // SMTP username
      $mail->Password   = Config::EMAIL_PASSWORD;                               // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = Config::PORT;                                  // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      //Recipients
      $mail->setFrom('john@doe.example', 'John Doe');
      $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient


      // Attachments
      $mail->addStringAttachment($pdf, $data['name'].'.pdf');

      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Here is the subject';
      $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $mail->send();

      header('Location: /insurances/' . $latInsertedId . '/show');

    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

  }


}