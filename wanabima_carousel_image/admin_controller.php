<?php
/**
 * Created by PhpStorm.
 * User: emalsha
 * Date: 29/03/18
 * Time: 11:29 AM
 */


?>
<style>
    * {
        box-sizing: border-box;
    }

    input[type=text], input[type=url], select, textarea {
        width: 100%;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
    }

    label {
        padding: 5px 5px 5px 0;
        display: inline-block;
    }

    input[type=submit] {
        background-color: rgba(106, 114, 114, 0.8);
        color: white;
        padding: 6px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: right;
    }

    input[type=submit]:hover {
        background-color: rgba(106, 114, 114, 0.4);
    }

    .container {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
        width: 75%;
        min-height: 306px;
    }

    .container-head {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
        width: 75%;
    }

    .col-25 {
        float: left;
        width: 25%;
        margin-top: 6px;
    }

    .col-50 {
        float: left;
        width: 50%;
        margin-top: 6px;
    }

    .col-75 {
        float: left;
        width: 75%;
        margin-top: 6px;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    @media screen and (max-width: 600px) {
        .col-25, .col-75, input[type=submit] {
            width: 100%;
            margin-top: 0;
        }

        .container {
            width: 100%;
        }
    }
</style>


<div class="container-head">
    <form action="" method="get">
        <input type="hidden" value="wanabimaplugin/plugin-carousel-image-admin.php" name="page">
        <div class="row">
            <div class="col-25">
                <label for="country">Page</label>
            </div>
            <div class="col-75">
                <select id="select_content" name="content">
                    <?php

                    global $wpdb;

                    $available_content = $wpdb->get_results("SELECT id,page FROM " . $wpdb->prefix . "carousel_image GROUP BY page");
                    if ($available_content) {
                        foreach ($available_content as $content) {
                            ?>
                            <option value="<?php echo $content->page; ?>"><?php echo ucfirst(str_replace('_', ' ', $content->page)) . " page " ?></option>
                            <?php
                        }
                    }

                    ?>

                </select>
            </div>
        </div>
        <div class="row">
            <input type="submit" value="Edit">
        </div>
    </form>
</div>

<div class="row">


    <?php

    if ($_GET['content']) {
        panelShow();
    }

    function panelShow()
    {
        global $wpdb;

        if ($_GET['content']) {
            $results_set = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "carousel_image WHERE page='" . $_GET['content'] . "'");

            if ($results_set) {
                foreach ($results_set as $result) {
                    ?>
                    <div class="container col-50" style="border-right:1px solid grey;">
                        <div class="row">
                            <div class="col-75">
                                <h3 style="text-transform: capitalize">Page
                                    : <?php echo ucfirst(str_replace('_', ' ', $result->page)) ?></h3>

                            </div>
                        </div>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $result->id; ?>">

                            <div class="row">
                                <div class="col-25">
                                    <label for="content">Image</label>
                                </div>
                                <div class="col-75">

                                    <?php $attachmentImg = wp_get_attachment_image_src($result->image);
                                    if ($attachmentImg) {
                                        ?>
                                        <img src="<?php echo $attachmentImg[0] ?>" alt="">
                                        <?php
                                    }
                                    ?>
                                    <input type="hidden" value="<?php echo $result->image ?>"
                                           class="regular-text process_custom_images"
                                           id="process_custom_images" name="image" max="" min="1" step="1">
                                    <button class="set_custom_images button">Set Image</button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <input type="submit" name="submit" value="Submit">
                            </div>
                        </form>
                    </div>


                    <?php
                }
            }
        }
    }

    ?>
</div>
<script>
    jQuery(document).ready(function () {
        var $ = jQuery;
        if ($('.set_custom_images').length > 0) {
            if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
                $(document).on('click', '.set_custom_images', function (e) {
                    e.preventDefault();
                    var button = $(this);
                    var id = button.prev();
                    wp.media.editor.send.attachment = function (props, attachment) {
                        id.val(attachment.id);
                    };
                    wp.media.editor.open(button);
                    return false;
                });
            }
        }
    });
</script>

<?php

if ($_POST['submit'] == "Submit") {
    $update_result = $wpdb->update(
        $wpdb->prefix . "carousel_image",
        array(
            'image' => $_POST['image']
        ),
        array(
            'id' => $_POST['id'],
        ),
        array(
            '%s'
        ),
        array(
            '%d'
        )
    );

    if ($update_result) {
        echo "<meta http-equiv='refresh' content='0'";
    }

}

?>

