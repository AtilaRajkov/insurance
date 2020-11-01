<?php
require(dirname(__DIR__) . '../partials/_header.php');
require(dirname(__DIR__) . '../partials/_navigation.php');
?>

<h1>Prikaz svih osiguranja</h1>

<?php
if (isset($data) && count($data) > 0) {

  ?>
  <table style="width:100%">
    <tr>
      <th>Datum unosa
        <a href="/insurances/index?column=created_at&order=desc"><img class="arrow" src="/img/arrow-down.png" alt=""></a>
        <a href="/insurances/index?column=created_at&order=asc"><img class="arrow" src="/img/arrow-up.png" alt=""></a>
      </th>
      <th>Nosilac polise
        <a href="/insurances/index?column=name&order=desc"><img class="arrow" src="/img/arrow-down.png" alt=""></a>
        <a href="/insurances/index?column=name&order=asc"><img class="arrow" src="/img/arrow-up.png" alt=""></a>
      </th>
      <th>Datum rođenja
        <a href="/insurances/index?column=birth_date&order=desc"><img class="arrow" src="/img/arrow-down.png" alt=""></a>
        <a href="/insurances/index?column=birth_date&order=asc"><img class="arrow" src="/img/arrow-up.png" alt=""></a>
      </th>
      <th>Telefon
        <a href="/insurances/index?column=phone&order=desc"><img class="arrow" src="/img/arrow-down.png" alt=""></a>
        <a href="/insurances/index?column=phone&order=asc"><img class="arrow" src="/img/arrow-up.png" alt=""></a>
      </th>
      <th>Broj pasoša
        <a href="/insurances/index?column=passport&order=desc"><img class="arrow" src="/img/arrow-down.png" alt=""></a>
        <a href="/insurances/index?column=passport&order=asc"><img class="arrow" src="/img/arrow-up.png" alt=""></a>
      </th>
      <th>Email
        <a href="/insurances/index?column=email&order=desc"><img class="arrow" src="/img/arrow-down.png" alt=""></a>
        <a href="/insurances/index?column=email&order=asc"><img class="arrow" src="/img/arrow-up.png" alt=""></a>
      </th>
      <th>Od
        <a href="/insurances/index?column=date_from&order=desc"><img class="arrow" src="/img/arrow-down.png" alt=""></a>
        <a href="/insurances/index?column=date_from&order=asc"><img class="arrow" src="/img/arrow-up.png" alt=""></a>
      </th>
      <th>Do
        <a href="/insurances/index?column=date_to&order=desc"><img class="arrow" src="/img/arrow-down.png" alt=""></a>
        <a href="/insurances/index?column=date_to&order=asc"><img class="arrow" src="/img/arrow-up.png" alt=""></a>
      </th>
      <th>Broj dana
        <a href="/insurances/index?column=number_of_days&order=desc"><img class="arrow" src="/img/arrow-down.png" alt=""></a>
        <a href="/insurances/index?column=number_of_days&order=asc"><img class="arrow" src="/img/arrow-up.png" alt=""></a>
      </th>
      <th>Tip
        <a href="/insurances/index?column=type&order=desc"><img class="arrow" src="/img/arrow-down.png" alt=""></a>
        <a href="/insurances/index?column=type&order=asc"><img class="arrow" src="/img/arrow-up.png" alt=""></a>
      </th>
    </tr>
    <?php
      foreach($data as $key => $value) {
        ?>
        <tr>
          <td><?php echo $value['created_at'] ?? 'Nema podataka'; ?></td>
          <td><?php echo $value['name'] ?? 'Nema podataka'; ?></td>
          <td><?php echo $value['birth_date'] ?? 'Nema podataka'; ?></td>
          <td><?php echo $value['phone'] ?? 'Nema podataka'; ?></td>
          <td><?php echo $value['passport'] ?? 'Nema podataka'; ?></td>
          <td><?php echo $value['email'] ?? 'Nema podataka'; ?></td>
          <td><?php echo $value['date_from'] ?? 'Nema podataka'; ?></td>
          <td><?php echo $value['date_to'] ?? 'Nema podataka'; ?></td>
          <td><?php echo $value['number_of_days'] ?? 'Nema podataka'; ?></td>
          <td>
            <?php
              if (
                isset($value['type']) &&
                $value['type'] == \App\Models\Insurance::GROUP
              ) {
                ?>
                <a href="/insurances/<?php echo  $value['id']; ?>/show">
                  Grupno
                </a>
                <?php
              } else {
                ?>
                <a href="/insurances/<?php echo  $value['id']; ?>/show">
                  Individualno
                </a>
                <?php
              }
            ?>
          </td>
        </tr>
        <?php
      }
    ?>
  </table>
  <?php
//  echo "<pre>" . print_r($data, true) . "</pre>";
} else {
  ?>
  <p>Nema podataka u bazi</p>
<?php
}
?>



</div>




</body>
</html>