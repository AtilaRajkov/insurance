<?php
require(dirname(__DIR__) . '../partials/_header.php');
require(dirname(__DIR__) . '../partials/_navigation.php');
?>

<h1>Nosioci osiguranja</h1>


<?php
if (isset($data) && count($data) > 0) {

  ?>
  <table >
    <tr>

      <th>Nosioc sipolise osiguranja
        <a href="/insurances/users-table?column=name&order=desc"><img class="arrow" src="/img/arrow-down.png" alt=""></a>
        <a href="/insurances/users-table?column=name&order=asc"><img class="arrow" src="/img/arrow-up.png" alt=""></a>
      </th>

    </tr>
    <?php
    foreach($data as $key => $value) {
      ?>
      <tr>
        <td>
          <a href="/insurances/<?php echo $value['id']; ?>/show-user-table">
            <?php echo $value['name'] ?? 'Nema podataka'; ?>
          </a>
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