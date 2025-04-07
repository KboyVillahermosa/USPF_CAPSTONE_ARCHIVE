<?php return array (
  'backpack/basset' => 
  array (
    'aliases' => 
    array (
      'Basset' => 'Backpack\\Basset\\Facades\\Basset',
    ),
    'providers' => 
    array (
      0 => 'Backpack\\Basset\\BassetServiceProvider',
    ),
  ),
  'backpack/crud' => 
  array (
    'aliases' => 
    array (
      'CRUD' => 'Backpack\\CRUD\\app\\Library\\CrudPanel\\CrudPanelFacade',
      'Widget' => 'Backpack\\CRUD\\app\\Library\\Widget',
    ),
    'providers' => 
    array (
      0 => 'Backpack\\CRUD\\BackpackServiceProvider',
    ),
  ),
  'backpack/generators' => 
  array (
    'providers' => 
    array (
      0 => 'Backpack\\Generators\\GeneratorsServiceProvider',
    ),
  ),
  'backpack/theme-tabler' => 
  array (
    'providers' => 
    array (
      0 => 'Backpack\\ThemeTabler\\AddonServiceProvider',
    ),
  ),
  'creativeorange/gravatar' => 
  array (
    'aliases' => 
    array (
      'Gravatar' => 'Creativeorange\\Gravatar\\Facades\\Gravatar',
    ),
    'providers' => 
    array (
      0 => 'Creativeorange\\Gravatar\\GravatarServiceProvider',
    ),
  ),
  'laravel/breeze' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Breeze\\BreezeServiceProvider',
    ),
  ),
  'laravel/pail' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Pail\\PailServiceProvider',
    ),
  ),
  'laravel/sail' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sail\\SailServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'nunomaduro/termwind' => 
  array (
    'providers' => 
    array (
      0 => 'Termwind\\Laravel\\TermwindServiceProvider',
    ),
  ),
  'pestphp/pest-plugin-laravel' => 
  array (
    'providers' => 
    array (
      0 => 'Pest\\Laravel\\PestServiceProvider',
    ),
  ),
  'prologue/alerts' => 
  array (
    'aliases' => 
    array (
      'Alert' => 'Prologue\\Alerts\\Facades\\Alert',
    ),
    'providers' => 
    array (
      0 => 'Prologue\\Alerts\\AlertsServiceProvider',
    ),
  ),
);