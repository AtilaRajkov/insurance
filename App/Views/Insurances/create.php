<?php
require(dirname(__DIR__) . '../partials/_header.php');
require(dirname(__DIR__) . '../partials/_navigation.php');
?>

<h1>Novo Osiguanje</h1>

<p><small>Polja sa zvezdicom (*) su obavezna.</small></p>
<p><small>Datumi moraju biti uneti u formatu dd-mm-gggg (npr. 27-04-1989).</small></p>

<form action="/insurances/store" method="post">

  <div class="input-group">
    <p>
      <label for="name">Nosilac osiguranja (Ime i Prezime)*</label>
    </p>

    <input type="text" size="40" name="name" id="name"
           value="<?php echo $data['name'] ?? ''; ?>"
    />
    <span class="error">
      <?php echo $errors['name'] ?? ''; ?>
    </span>
  </div>

  <div class="input-group">
    <label for="birth_date">Datum rođenja *</label>
    <input type="text" size="40" name="birth_date" id="birth_date"
           value="<?php echo $data['birth_date'] ?? ''; ?>"
    />
    <span class="error">
      <?php echo $errors['birth_date'] ?? ''; ?>
    </span>
  </div>

  <div class="input-group">
    <label for="phone">Broj telefona</label>
    <input type="text" size="40" name="phone" id="phone"
           value="<?php echo $data['phone'] ?? ''; ?>"
    />
    <span class="error">
      <?php echo $errors['phone'] ?? ''; ?>
    </span>
  </div>

  <div class="input-group">
    <label for="passport">Broj pasoša *</label>
    <input type="text" size="40" name="passport" id="passport"
           value="<?php echo $data['passport'] ?? ''; ?>"
    />
    <span class="error">
      <?php echo $errors['passport'] ?? ''; ?>
    </span>
  </div>

  <div class="input-group">
    <label for="email">Email *</label>
    <input type="text" size="40" name="email" id="email"
           value="<?php echo $data['email'] ?? ''; ?>"
    />
    <span class="error">
      <?php echo $errors['email'] ?? ''; ?>
    </span>
  </div>


  <div class="input-group">
    <label for="date_from">Početak putovanja *</label>
    <input type="text" size="20" name="date_from" id="date_from"
           value="<?php echo $data['date_from'] ?? ''; ?>"
    />
    <span class="error">
      <?php echo $errors['date_from'] ?? ''; ?>
    </span>
  </div>

  <div class="input-group">
    <label for="date_to">Kraj putovanja *</label>
    <input type="text" size="20" name="date_to" id="date_to"
           value="<?php echo $data['date_to'] ?? ''; ?>"
    />
    <span class="error">
      <?php echo $errors['date_to'] ?? ''; ?>
    </span>
  </div>

  <div class="input-group">
    <p>
      Odabrali ste osiguranje za <b>
      <span id="numberOfDays">
        <?php echo $data['number_of_days'] ?? '0'; ?>
      </span></b> dana.
      <span class="error">
        <?php echo $errors['number_of_days'] ?? ''; ?>
      </span>
    </p>
    <input type="hidden" name="number_of_days" id="number_of_days" >
  </div>

  <div class="input-group">
    <label for="type">Odabir vrste polise osiguranja</label>

    <select name="type" id="type" >
      <option value="single"
        <?php echo (isset($data['type']) && $data['type'] == 'single') ? 'selected' : ''; ?>
      >Individualno</option>
      <option value="group"
        <?php echo (isset($data['type']) && $data['type'] == 'group') ? 'selected' : ''; ?>
      >Grupno</option>
    </select>

    <span class="error">
      <?php echo $errors['type'] ?? ''; ?>
    </span>
  </div>


  <div class="input-group" id="field-wrapper">
    <button id="addPerson">Dodajte osobu</button>
  </div>


  <div id="additional-people-container">
    <?php if (
      isset($data['people']) &&
      $data['type'] == \App\Models\Insurance::GROUP &&
      count($data['people']) > 0
    ) { ?>

      <?php foreach ($data['people'] as $key => $person) { ?>
        <div class="input-group">

          <label >Ime i prezime</label>
          <input type="text" name="people[<?php echo $key; ?>][name]"
                 value="<?php echo $person['name']; ?>"/>
          <span class="error">
            <?php echo $errors['people'][$key]['name'] ?? ''; ?>
          </span>
          <br>
          <label>Datum rođenja</label>

          <input type="text" name="people[<?php echo $key ;?>][birth_date]"
                 value="<?php echo $person['birth_date'] ?>"/>
          <a href="javascript:void(0);" class="remove_button">
            <img class="remove-image" src="/img/remove-23.png"/></a>
          <span class="error">
            <?php echo $errors['people'][$key]['birth_date'] ?? ''; ?>
          </span>
          <br>

          <label>Broj pasoša</label>
          <input type="text" name="people[<?php echo $key ;?>][passport]"
                 value="<?php echo $person['passport'] ?>"/>
          <span class="error">
            <?php echo $errors['people'][$key]['passport'] ?? ''; ?>
          </span><br>
          <input type="hidden" name="people[<?php echo $key ;?>][key]"
                 value="<?php echo $key ;?>"/>
          <br>
        </div>
      <?php } ?>

    <?php } ?>
  </div>


  <div>
    <input type="submit" value="Pošalji" name="submitButton"/>
  </div>


  <input type="hidden" id="lats_people_key"
         value="<?php echo $data['lats_people_key'] ?? ''; ?>">

</form>

</div>


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/insurances.js"></script>


</body>
</html>