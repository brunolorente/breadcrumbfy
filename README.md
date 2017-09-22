
# BreadcrumbFy 0.0.1
BreadcrumbFy is the easiest way to generate WordPress breadcrumbs

## Installation
Open the appropriate file for your theme *(typically header.php or page.php)*. This can be done within WordPress’ **administration panel through Presentation > Theme Editor** or through your favorite text editor. 

Place the following code where you want the breadcrumb trail to appear.

    <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
	    <?php 
            if (function_exists('get_breadcrumbfy')) {
                get_breadcrumbfy(); 
            } else{
                echo "You need to activate/install BreadcrumbFy WP Plugin before the BreadcrumbFy feature is available";

            }
        ?>
    </div>

Save the file (upload if applicable). 

Now you should have a breadcrumb trail on your WordPress powered site.