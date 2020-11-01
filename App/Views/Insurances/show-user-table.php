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
      <th>Datum unosa</th>
      <th>Nosilac polise</th>
      <th>Datum rođenja</th>
      <th>Telefon</th>
      <th>Broj pasoša</th>
      <th>Email</th>
      <th>Od</th>
      <th>Do</th>
      <th>Broj dana</th>
      <th>Tip</th>
    </tr>
    <?php
//    foreach($data as $key => $data) {
      ?>
      <tr>
        <td><?php echo $data['created_at'] ?? 'Nema podataka'; ?></td>
        <td><?php echo $data['name'] ?? 'Nema podataka'; ?></td>
        <td><?php echo $data['birth_date'] ?? 'Nema podataka'; ?></td>
        <td><?php echo $data['phone'] ?? 'Nema podataka'; ?></td>
        <td><?php echo $data['passport'] ?? 'Nema podataka'; ?></td>
        <td><?php echo $data['email'] ?? 'Nema podataka'; ?></td>
        <td><?php echo $data['date_from'] ?? 'Nema podataka'; ?></td>
        <td><?php echo $data['date_to'] ?? 'Nema podataka'; ?></td>
        <td><?php echo $data['number_of_days'] ?? 'Nema podataka'; ?></td>
        <td>
          <?php
          if (
            isset($data['type']) &&
            $data['type'] == \App\Models\Insurance::GROUP
          ) {
            ?>
            <a href="/insurances/<?php echo  $data['id']; ?>/show">
              Grupno
            </a>
            <?php
          } else {
            ?>
              Individualno
            <?php
          }
          ?>
        </td>
      </tr>
      <?php
//    }
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