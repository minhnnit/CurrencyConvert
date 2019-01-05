<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /* @date($var) */
        \Blade::extend(function($view, $compiler)
        {
            $pattern = $compiler->createOpenMatcher('date');

            return preg_replace($pattern, '$1<?php echo $2->format(\'d M Y\')); ?>', $view);
        });

        /* @datetime($var) */
        \Blade::extend(function($view, $compiler)
        {
            $pattern = $compiler->createOpenMatcher('datetime');

            return preg_replace($pattern, '$1<?php echo $2->format(\'d M Y H:i\')); ?>', $view);
        });

        /* @eval($var++) */
        \Blade::extend(function($view)
        {
            return preg_replace('/\@eval\((.+)\)/', '<?php ${1}; ?>', $view);
        });

        /**
         * <code>
         * {? $old_section = "whatever" ?}
         * </code>
         */
        \Blade::extend(function($value) {
            return preg_replace('/\{\?(.+)\?\}/', '<?php ${1} ?>', $value);
        });

        /**
         * break | continue
         */
        \Blade::extend(function($value)
        {
            $replace = array('@break', '@continue');
            $to = array('<?php break; ?>', '<?php continue; ?>');
            return str_replace($replace, $to, $value);
        });
    }

    public function register()
    {
        //
    }
}