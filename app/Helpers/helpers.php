<?php
function getAwemeIdByUrl($url)
{
    if (is_numeric($url)) {
        return $url;
    }

    preg_match('/share\/video\/(\d*)\//', $url, $matches);

    return $matches[1] ?? null;
}
