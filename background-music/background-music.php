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
    echo '<button id="music-control" class="pause"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M48 64C21.5 64 0 85.5 0 112V400c0 26.5 21.5 48 48 48H80c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zm192 0c-26.5 0-48 21.5-48 48V400c0 26.5 21.5 48 48 48h32c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H240z"/></svg></button>';
    echo '<style>
        #music-control {
            position: fixed;
            bottom: 20px;
            left: 20px;
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
                    control.innerHTML = "<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M48 64C21.5 64 0 85.5 0 112V400c0 26.5 21.5 48 48 48H80c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zm192 0c-26.5 0-48 21.5-48 48V400c0 26.5 21.5 48 48 48h32c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H240z"/></svg>";
                } else {
                    music.pause();
                    control.classList.remove("pause");
                    control.classList.add("play");
                    control.innerHTML = "<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg>";
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
  $banner_url = 'https://adenwalla.in/wp-content/uploads/2023/02/Black-Elegant-Personal-LinkedIn-Banner.png';
  echo '<img src="'.$banner_url.'" style="width:100%;margin-bottom:20px;margin-top:20px;margin-right:20px;">';
}
add_action('admin_notices', 'admin_banner_image');