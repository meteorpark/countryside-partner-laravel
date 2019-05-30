@servers(['web' => ['49.236.137.197']])

@task('git')
    cd /var/www/html/countryside-partner-laravel
    git pull origin master
@endtask
