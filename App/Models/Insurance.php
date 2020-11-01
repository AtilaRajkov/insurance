<?php

namespace App\Models;

use PDO;

/**
 * Insurance model
 *
 * @package App\Models
 */
class Insurance extends \Core\Model
{

  const SINGLE = 'single';
  const GROUP = 'group';


  /**
   * @param $data
   * @return mixed
   * @throws \Exception
   */
  public static function insert($data)
  {
    try {

      $pdo = static::getDB();

      $inserted = false;

      $sql = "INSERT INTO insurances(
                name, 
                birth_date,
                phone, 
                passport,
                email,
                date_from,
                date_to,
                type,
                number_of_days
            ) VALUES (
                :name, 
                :birth_date,
                :phone, 
                :passport,
                :email,
                :date_from,
                :date_to,
                :type,
                :number_of_days)";

      $stmt = $pdo->prepare($sql);

      $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
      $stmt->bindParam(':birth_date', $data['birth_date'], PDO::PARAM_STR);
      $stmt->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
      $stmt->bindParam(':passport', $data['passport'], PDO::PARAM_STR);
      $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $stmt->bindParam(':date_from', $data['date_from'], PDO::PARAM_STR);
      $stmt->bindParam(':date_to', $data['date_to'], PDO::PARAM_STR);
      $stmt->bindParam(':type', $data['type'], PDO::PARAM_STR);
      $stmt->bindParam(':number_of_days', $data['number_of_days'], PDO::PARAM_INT);

      $inserted = $stmt->execute();
      $newId = $pdo->lastInsertId();

      // Inserting additional people
      if (
        $inserted &&
        $data['type'] == Insurance::GROUP &&
        isset($data['people']) &&
        count($data['people']) > 0
      ) {

        foreach ($data['people'] as $value) {

          $peopleSQL = 'INSERT INTO additional_people(
                          name,
                          insurance_id,
                          birth_date,
                          passport
                      ) VALUES(
                          :name,
                          :insurance_id,
                          :birth_date,
                          :passport)';

          $peopleStmt = $pdo->prepare($peopleSQL);

          $peopleStmt->bindParam(':name', $value['name'], PDO::PARAM_STR);
          $peopleStmt->bindParam(':insurance_id', $newId, PDO::PARAM_INT);
          $peopleStmt->bindParam(':birth_date', $value['birth_date'], PDO::PARAM_STR);
          $peopleStmt->bindParam(':passport', $value['passport'], PDO::PARAM_STR);

          $inserted = $peopleStmt->execute();
        }

      }

      if ($inserted) {
        return $newId;
      } else {
        throw new \Exception('Greška pri upisu u bazu!');
      }


    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  /**
   * @param $id
   * @return mixed
   * @throws \Exception
   */
  public static function getOne($id)
  {

    try {

      $pdo = static::getDB();

      $sql = "SELECT * FROM insurances WHERE id = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$id]);
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      // Selecting additional people if it's needed
      if ($data && $data['type'] == self::GROUP) {

        $peopleSQL = "SELECT *
                      FROM additional_people
                      WHERE insurance_id = ?";
        $peopleStmt = $pdo->prepare($peopleSQL);
        $peopleStmt->execute([$id]);
        $people = $peopleStmt->fetchAll(PDO::FETCH_ASSOC);

        if ($data) {
          $data['people'] = $people;
        } else {
          throw new \Exception('Greška pri čitanju iz baze!');
        }

      }

//      echo '<pre>' . print_r($data,true) . '</pre>';

      if ($data) {
        return $data;
      } else {
        throw new \Exception('Dato osiguranje ne postoji u bazi!');
      }

    } catch (PDOException $e) {
      echo $e->getMessage();
    }

  }


  /**
   * Fetching all the data form the insurances table
   *
   * @return mixed
   * @throws \Exception
   */
  public static function getAll($column = NULL, $order = NULL)
  {
    try {

      $pdo = static::getDB();

      $sql = "SELECT * FROM insurances";

      if (!is_numeric($column) && !is_null($order)) {
        $sql .= " ORDER BY $column $order";
      }


      $data = $pdo->query($sql)
                  ->fetchAll(PDO::FETCH_ASSOC);

      if ($data) {
        return $data;
      } else {
        //throw new \Exception('Baza je prazna');
        return [];
      }


    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }


  public static function getAllNames($column = NULL, $order = NULL)
  {
    try {

      $pdo = static::getDB();

      $sql = "SELECT * FROM insurances";

      if (!is_numeric($column) && !is_null($order)) {
        $sql .= " ORDER BY $column $order";
      }


      $data = $pdo->query($sql)
        ->fetchAll(PDO::FETCH_ASSOC);

      if ($data) {
        return $data;
      } else {
//        throw new \Exception('Baza je prazna');
        return [];
      }


    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }




}