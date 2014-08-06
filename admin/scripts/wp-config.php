<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
//define( 'WPCACHEHOME', '/opt/www/noticias/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
//define('WP_CACHE', true); //Added by WP-Cache Manager
define('DB_NAME', 'carsale');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'a485618455b4d7471a4e708157096232');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '*$HWA 0:WK2},:l9;]_Z,KCAb:C+rRNri_?@f;(_$2}.doy%vv/Z-m7-R,NH+}&A');
define('SECURE_AUTH_KEY',  's[eqWF=YDF eRN?A&&nYN47@9Mh}Q#5WmdI?N]9<f:E<3g;ybW7i<U@5^x5ZlQT9');
define('LOGGED_IN_KEY',    't7jAdtc^IJ^_vxfK<E+-4^2mJT!(A0p!2/yTvfzeW7(O_8aLjOCGDIRJ}bFGzq6=');
define('NONCE_KEY',        'Xqj,T(vT`?nmA.=PJfhK34-a7?.,DBQ:CB}C{Hr/!|PHKmnUVsIHUzxHuX2H>WVF');
define('AUTH_SALT',        'tH:5X1| a2J<<Z3_XqWY$py$i_A^_b2!7+3q1=^Tu?hlI=)>_|ZL=UL ?E-N{@Tb');
define('SECURE_AUTH_SALT', '1|HObZ}KpC;*c))Ur4caQj]BdU8 A8|7)W7r=**m UY d!9Z.C]|*A<[Shbd`4s<');
define('LOGGED_IN_SALT',   'ntd{N^;oT**(Br=(VF9+Dd*3Zh&Al{vRRTGf/E/-Pm+V}/F;G9Vo+{P6>:s;r1vD');
define('NONCE_SALT',       'H9ld4vYXse-kp8UmH2c^2tlU#ATzF&4s]AQa}|)fX1(BK0nW+B68& 4~.X7z)1s^');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_news_';

/**
 * O idioma localizado do WordPress é o inglês por padrão.
 *
 * Altere esta definição para localizar o WordPress. Um arquivo MO correspondente ao
 * idioma escolhido deve ser instalado em wp-content/languages. Por exemplo, instale
 * pt_BR.mo em wp-content/languages e altere WPLANG para 'pt_BR' para habilitar o suporte
 * ao português do Brasil.
 */
define('WPLANG', 'pt_BR');

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
