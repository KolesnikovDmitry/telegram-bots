<?php
function debug($data) : void
{
    echo "<pre>" . print_r($data, 1) . "</pre>";
}

function send_request(string $method, array $params = []) :mixed
{
    $url = BASE_URL . $method;
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    return json_decode(file_get_contents(
        $url,
       false,
        stream_context_create(['http' => ['ignore_errors' => true]])
    ));
}
