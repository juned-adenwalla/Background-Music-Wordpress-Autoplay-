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
        echo '<script>
            document.getElementById("background-music").play();
            </script>';
    }
}
add_action('wp_footer', 'background_music');


function load_fontawesome_css() {
    wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.15.1/css/all.css' );
}
add_action( 'wp_enqueue_scripts', 'load_fontawesome_css' );

function music_controls() {
    $location = get_option('music_control_location');
    $enabled = get_option('music_enabled');
    if (!$enabled) {
        return;
    }
    echo '<button id="music-control" class="pause">⏸️ Pause</button>';
    echo '<style>
        #music-control {
            position: fixed;
            ' . ($location == 'top-left' || $location == 'bottom-left' ? 'left: 20px;' : 'right: 20px;') . '
            ' . ($location == 'top-left' || $location == 'top-right' ? 'top: 20px;' : 'bottom: 20px;') . '
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
                    control.innerHTML = "⏸️ Pause";
                } else {
                    music.pause();
                    control.classList.remove("pause");
                    control.classList.add("play");
                    control.innerHTML = "▶ Play";
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
        update_option('music_control_location', $_POST['music_control_location']);
        update_option('music_enabled', isset($_POST['music_enabled']) ? 1 : 0);
    }
    $music_url = get_option('music_url');
    $music_control_location = get_option('music_control_location');
    $music_enabled = get_option('music_enabled');
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
                    <tr>
                        <th scope="row">
                            <label for="music_control_location">Music Control Location</label>
                        </th>
                        <td>
                            <select id="music_control_location" name="music_control_location">
                                <option value="top-left" <?php selected($music_control_location, 'top-left'); ?>>Top Left</option>
                                <option value="top-right" <?php selected($music_control_location, 'top-right'); ?>>Top Right</option>
                                <option value="bottom-left" <?php selected($music_control_location, 'bottom-left'); ?>>Bottom Left</option>
                                <option value="bottom-right" <?php selected($music_control_location, 'bottom-right'); ?>>Bottom Right</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="music_enabled">Music Enabled</label>
                        </th>
                        <td>
                            <input type="checkbox" id="music_enabled" name="music_enabled" value="1" <?php checked($music_enabled, 1); ?>>
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