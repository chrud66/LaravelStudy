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

@servers(['vm' => 'deployer@kcklaravel'])


@setup
  $username = 'deployer';                       // username at the server
  $remote = 'https://github.com/chrud66/laravel.git';
  // $remote = 'git@github.com:appkr/envoy.git';   // github repository to clone
  $base_dir = "/home/{$username}/www";          // document that holds projects
  $project_root = "{$base_dir}/envoy.vm";       // project root
  $shared_dir = "{$base_dir}/shared";           // directory that will house shared dir/files
  $release_dir = "{$base_dir}/releases";        // release directory
  $distname = 'release_' . date('YmdHis');      // release name

  // ------------------------------------------------------------------
  // Leave the following as it is, if you don't know what they are for.
  // ------------------------------------------------------------------

  $required_dirs = [
    $shared_dir,
    $release_dir,
  ];

  $shared_item = [
    "{$shared_dir}/.env" => "{$release_dir}/{$distname}/.env",
    "{$shared_dir}/storage" => "{$release_dir}/{$distname}/storage",
    "{$shared_dir}/cache" => "{$release_dir}/{$distname}/bootstrap/cache",
  ];

  $branch = "master";
@endsetup

@task('foo', ['on' => 'vm'])
    ls -la
@endtask

@task('hello', ['on' => ['vm']])
  HOSTNAME=$(hostname);
  echo "Hello Envoy! Responding from $HOSTNAME";
@endtask


@task('deploy', ['on' => ['vm']])
  {{--Create directories if not exists--}}
  @foreach ($required_dirs as $dir)
    [ ! -d {{ $dir }} ] && mkdir -p {{ $dir }};
  @endforeach

  git pull origin {{ $branch }}

  {{--Run composer install--}}
  cd {{ $release_dir }}/{{ $distname }} && \
    [ -f ./composer.json ] && \
    composer install --prefer-dist --no-scripts --no-dev;

  {{--Set permission and change owner--}}
  [ -d {{ $shared_dir }}/storage ] && \
    chmod -R 775 {{ $shared_dir }}/storage;
  [ -d {{ $shared_dir }}/cache ] && \
    chmod -R 775 {{ $shared_dir }}/cache;
  chgrp -h -R www-data {{ $release_dir }}/{{ $distname }};

  {{--Restart web server.--}}
  sudo service nginx restart;
  sudo service php7.0-fpm restart;
@endtask