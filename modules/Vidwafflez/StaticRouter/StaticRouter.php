<?php
namespace Vidwafflez\StaticRouter;

use Vidwafflez\Common\Http;

class StaticRouter
{
    public static function handle(): void
    {
        $path = Http::getPath();

        // We don't need to check content type or anything
        // because static folder only has production files
        if (file_exists("static/" . $path[0] . "/" . $path[1])) {
            $filename = "static/" . $path[0] . "/" . $path[1];
            header("Content-Type: " . mime_content_type($filename));
            echo(file_get_contents($filename));
        } else {
            http_response_code(404);
            die("
            <h1>404 Not Found</h1>
            <p>The requested file does not exist.</p>
            ");
        }
    }
}