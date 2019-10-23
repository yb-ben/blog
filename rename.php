<?php
set_time_limit(0);
$target = __DIR__ . '/vendor';

function run($target)
{
    if (is_dir($target)) {
        foreach (scandir($target) as $item) {
            if ($item !== '.' && $item !== '..') {
                run($target . '/' . $item);
            }
        }
    }else{
        static $count = 1;
        rename($target, str_replace('.txt', '', $target, $count));
    }
}

run($target);