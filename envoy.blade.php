##--------------------------------------------------------------------------
# List of tasks, that you can run...
# e.g. envoy run hello
#--------------------------------------------------------------------------
#
# hello     Check ssh connection
# deploy    Publish new release
# list      Show list of releases
# checkout  Checkout to the given release (must provide --release=/path/to/release)
# prune     Purge old releases (must provide --keep=n, where n is a number)
#
#--------------------------------------------------------------------------
# Note that the server shoulbe be accessible through ssh with 'username' account
# $ ssh username@hostname
#--------------------------------------------------------------------------
##

@servers(['real' => 'deployer@13.209.66.162']);


@setup
  $username = 'deployer'; // username at the server
  $remote = 'https://github.com/chrud66/laravel.git';
  $base_dir = "/home/{$username}/www"; // document that holds projects
  $appdir = '/home/deployer/www/laravel';
  $branch = 'master';
@endsetup

@task('foo-real', ['on' => ['real']])
    echo 'Working  on ' . `hostname`;
    ls -la
@endtask

@task('hello', ['on' => ['real']])
  HOSTNAME=$(hostname);
  echo "Hello Envoy! Responding from $HOSTNAME";
@endtask


@task('deploy', ['on' => ['real']])
  echo 'Working on ' . `hostname`
  cd {{ $appdir }}
  php artisan down
  git pull origin {{ $branch }}
  composer install
  composer dump-autoload
  php artisan config:cache
  php artisan up

  sudo service apache2 restart;
  echo "rev hash :" `git rev-parse --verify HEAD`
@endtask