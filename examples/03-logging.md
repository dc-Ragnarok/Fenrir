### Logging

Sometimes it may be useful to inspect what Fenrir is doing in the background. For this you can pass a [PSR-3](https://www.php-fig.org/psr/psr-3/) compatible logger. The one used in this example, is a [Monolog](https://github.com/Seldaek/monolog) logger.

This logging will contain HTTP requests being made and all packets sent to and from Discords Gateway.
