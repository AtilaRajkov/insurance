<?php
require(dirname(__DIR__) . '../partials/_header.php');
require(dirname(__DIR__) . '../partials/_navigation.php');
?>

<h1>Prikaz osiguranja</h1>


<?php
if (isset($data) && count($data) > 0) {
//  echo "<pre>" . print_r($data, true) . "</pre>";
?>
  <p>Nosilac polise: <b><?php echo $data['name'] ?? 'Nema podataka'; ?></b></p>
  <p>Datum rođenja: <b><?php echo $data['birth_date'] ?? 'Nema podataka'; ?></b></p>
  <p>Broj pasoša: <b><?php echo $data['passport'] ?? 'Nema podataka'; ?></b></p>
  <p>Telefon: <b><?php echo $data['phone'] ?? 'Nema podataka'; ?></b></p>
  <p>Email: <b><?php echo $data['email'] ?? 'Nema podataka'; ?></b></p>
  <p>Početak putovanja: <b><?php echo $data['date_from'] ?? 'Nema podataka'; ?></b></p>
  <p>Broj dana: <b><?php echo $data['number_of_days'] ?? 'Nema podataka'; ?></b></p>
  <p>Kraj putovanja: <b><?php echo $data['date_to'] ?? 'Nema podataka'; ?></b></p>
  <p>Vrsta polise osiguranja: <b>
      <?php
      if (isset($data['type'])) {
        if ($data['type'] == \App\Models\Insurance::GROUP) {
          echo 'Grupno';
        } else {
          echo 'individualno';
        }
      } else {
        echo 'Nema podataka';
      }
      ?>
    </b></p>

  <?php
    if (
      $data['type'] == \App\Models\Insurance::GROUP &&
      isset($data['people']) &&
      count($data['people']) > 0
    ) {
      ?>
      <h3>Dodatni osiguranici: </h3>
      <?php
      foreach ($data['people'] as $key => $value) {
        ?>
        <div class="people-group">
          <p>Ime i prezime: <b><?php echo $value['name'] ?? 'Nema podataka'; ?></b></p>
          <p>Datum rođenja: <b><?php echo $value['birth_date'] ?? 'Nema podataka'; ?></b></p>
          <p>Broj pasoša: <b><?php echo $value['passport'] ?? 'Nema podataka'; ?></b></p>
        </div>

        <?php
      }
    }

  ?>

<?php

} else {
?>
  <p>Nema podataka u bazi.</p>
<?php
}
?>



</div>


<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
<!--<script src="/js/insurances.js"></script>-->


</body>
</html>