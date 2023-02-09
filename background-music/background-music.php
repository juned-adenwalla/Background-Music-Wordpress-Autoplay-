<?php
/**
 * Plugin Name: Background Music (Wordpress Autoplay)
 * Plugin URI: https://github.com/juned-adenwalla/Background-Music-Wordpress-Autoplay-
 * Description: A plugin to play music in the background when the site is loaded, add a floating button on all pages to pause or resume music.
 * Version: 1.0
 * Author: Juned Adenwalla
 * Author URI: https://adenwalla.in
 * License: GPL2
 */

function background_music() {
    $music_url = get_option('music_url'); // get the music URL from the options
    if (!empty($music_url)) { // if the music URL is not empty
        echo '<audio id="background-music" src="'.$music_url.'" autoplay loop></audio>';
    }
}
add_action('wp_footer', 'background_music');

function music_controls() {
    echo '<button id="music-control" class="pause">Pause</button>';
    echo '<style>
        #music-control {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
            display: block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 50px;
            cursor: pointer;
        }
    </style>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var music = document.getElementById("background-music");
            var control = document.getElementById("music-control");
            control.addEventListener("click", function() {
                if (music.paused) {
                    music.play();
                    control.classList.remove("play");
                    control.classList.add("pause");
                    control.innerHTML = "Pause";
                } else {
                    music.pause();
                    control.classList.remove("pause");
                    control.classList.add("play");
                    control.innerHTML = "Play";
                }
            });
        });
    </script>';
}
add_action('wp_footer', 'music_controls');

function background_music_settings_page() {
    add_options_page(
        'Background Music Settings', // page title
        'Background Music', // menu title
        'manage_options', // capability
        'background-music', // menu slug
        'background_music_settings_callback' // callback function
    );
}
add_action('admin_menu', 'background_music_settings_page');

function background_music_settings_callback() {
    if (isset($_POST['music_url'])) {
        update_option('music_url', $_POST['music_url']);
    }
    $music_url = get_option('music_url');
    ?>
    <div class="wrap">
        <h1>Background Music Settings</h1>
        <form method="post">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="music_url">Music URL</label>
                        </th>
                        <td>
                            <input type="text" id="music_url" name="music_url" value="<?php echo $music_url; ?>">
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="Save Changes">
            </p>
        </form>
    </div>
    <?php
}

function admin_banner_image() {
  $banner_url = 'https://example.com/banner.png';
  echo '<img src="'.$banner_url.'" style="width:100%;margin-bottom:20px;">';
}
add_action('admin_notices', 'admin_banner_image');