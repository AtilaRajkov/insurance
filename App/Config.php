<?php

namespace App;

/**
 * Application configuration
 *
 * @package App
 */
class Config
{

  /**
   * Show or hide error messages in screen
   * @var boolean
   */
  const SHOW_ERRORS = true;

  /**
   * Database host
   * @var string
   */
  const DB_HOST = 'localhost';

  /**
   * Database name
   * @var string
   */
  const DB_NAME = 'insurance_db';

  /**
   * Database user
   * @var string
   */
  const DB_USER = 'root';

  /**
   * Database password
   * @var string
   */
  const DB_PASSWORD = '';


  // Email Configuration
  const SMTP_DEBUG = false;
  const EMAIL_HOST = 'smtp.mailtrap.io';
  const EMAIL_USERNAME = 'ba30ee5192e1aa';
  const EMAIL_PASSWORD = 'c2302bd5339afb';
  const PORT = 2525;

}