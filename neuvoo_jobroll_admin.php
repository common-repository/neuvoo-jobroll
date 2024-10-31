<?php 

    	if($_POST['neuvoojobroll_hidden'] == 'Y') {
			//Form data sent
        
        $numberofjobspage = $_POST['neuvoojobroll_numberofjobspage'];  
        if (($numberofjobspage>15) || ($numberofjobspage<1)) $numberofjobspage = 15;
        update_option('neuvoojobroll_numberofjobspage', $numberofjobspage);  
        
        $defaultlocation = $_POST['neuvoojobroll_defaultlocation'];  
        update_option('neuvoojobroll_defaultlocation', $defaultlocation);  
        
        $defaultkeywords = $_POST['neuvoojobroll_defaultkeywords'];  
        update_option('neuvoojobroll_defaultkeywords', $defaultkeywords);  
        
        $revenue_option = $_POST['neuvoojobroll_revenue_option'];  
        update_option('neuvoojobroll_revenue_option', $revenue_option);
        
        $looknfeel = $_POST['neuvoojobroll_looknfeel'];  
        update_option('neuvoojobroll_looknfeel', $looknfeel);
        
        $defaultsort = $_POST['neuvoojobroll_defaultsort'];  
        update_option('neuvoojobroll_defaultsort', $defaultsort);
        
        $language = $_POST['neuvoojobroll_language'];  
        update_option('neuvoojobroll_language', $language);
        
        /* Personal Information */
        
        $firstname = $_POST['neuvoojobroll_firstname'];  
        update_option('neuvoojobroll_firstname', $firstname);
        
        $lastname = $_POST['neuvoojobroll_lastname'];  
        update_option('neuvoojobroll_lastname', $lastname);
        
        $email = $_POST['neuvoojobroll_email'];  
        update_option('neuvoojobroll_email', $email);
        
        $partnerid = file_get_contents('http://www.neuvoo.ca/api-search/jobroll/register-user.php?firstname='.urlencode($firstname).'&lastname='.urlencode($lastname).'&email='.urlencode($email).'&url='.urlencode($_SERVER['HTTP_REFERER']));
        
        update_option('neuvoojobroll_partnerid', $partnerid);
        
        ?>  

        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>  

        <?php
		} else {
		
			//Normal page display
                        $numberofjobspage = get_option('neuvoojobroll_numberofjobspage');
                        $defaultkeywords = get_option('neuvoojobroll_defaultkeywords');  
                        $defaultlocation = get_option('neuvoojobroll_defaultlocation');  
                        $revenue_option = get_option('neuvoojobroll_revenue_option');  
                        $firstname = get_option('neuvoojobroll_firstname');  
                        $lastname = get_option('neuvoojobroll_lastname');  
                        $email = get_option('neuvoojobroll_email');  
                        $partnerid = get_option('neuvoojobroll_partnerid');
                        $looknfeel = get_option('neuvoojobroll_looknfeel');
                        $defaultsort = get_option('neuvoojobroll_defaultsort');
                        $language = get_option('neuvoojobroll_language');
                
		}

		$data_gathered = file_get_contents('http://www.neuvoo.ca/api-search/jobroll/gather.php?email='.urlencode($email));
		$data = json_decode($data_gathered,1);
		
		$clicks = $data['clicks'];
		$prints = $data['prints'];
		$earnedthismonth = $data['earnings_this_month'];
		$earnedlastmonth = $data['earnings_last_month'];
		$unpaidearnings = $data['unpaid_earnings'];
		$nextpayment = $data['next_payment'];
		$lastpayment = $data['last_payment'];

        ?>
               <div class="wrap">

			<?php    echo "<h2>" . __( 'Neuvoo Jobroll Options', 'neuvoojobroll_trdom' ) . "</h2>"; ?>
			
			<?php $valid = (($partnerid=='') || ($partnerid=='a5cdd4aa0048b187f7182f1b9ce7a6a7')) ? False : True; ?>
			
            <?php if (!$valid) $partnerid = 'Please set your email address so we can generate a Partner ID for you.'; $partnerid = '<i>'.$partnerid.'</i>'; ?>
            
			<form name="neuvoojobroll_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                                <input type="hidden" name="neuvoojobroll_hidden" value="Y">  

                <?php    echo "<br/><br/><h4>" . 'Personal information (It\'s used for payment purposes only)' . "</h2>"; ?>

				<table>

                <tr><td><?php _e("First Name " ); ?></td><td><input type="text" name="neuvoojobroll_firstname" value="<?php echo $firstname; ?>" size="15"></td></tr>
                <tr><td><?php _e("Last Name " ); ?></td><td><input type="text" name="neuvoojobroll_lastname" value="<?php echo $lastname; ?>" size="15"></td></tr>
                <tr><td><?php _e("Email " ); ?></td><td><input type="text" name="neuvoojobroll_email" value="<?php echo $email; ?>" size="35"> <span style='color:red;'>*</span></td></tr>
                <tr><td style='padding:5px 0px;'><?php _e("Partner ID" ); ?></td><td><?php echo $partnerid; ?></td></tr>
				
				<?php if ($valid) { ?>
				
                <tr><td style='padding:5px 0px;'><?php _e("Clicks/Impressions (this month)" ); ?></td><td><?php echo "<b>$clicks/$prints</b>"; ?></td></tr>
                <tr><td style='padding:5px 0px;'><?php _e("Earnings this month" ); ?></td><td><?php echo "<b>$$earnedthismonth</b>"; ?></td></tr>
				<tr><td style='padding:5px 0px;'><?php _e("Earnings last month" ); ?></td><td><?php echo "<b>$$earnedlastmonth</b>"; ?></td></tr>
				<tr><td style='padding:5px 0px;'><?php _e("Unpaid earnings" ); ?></td><td><?php echo "<b>$$unpaidearnings</b>"; ?></td></tr>
				<tr><td style='padding:5px 0px;'><?php _e("Next payment" ); ?></td><td><?php echo "<b>$nextpayment</b>"; ?></td></tr>
				<?php if ($data['last_payment']!='') { ?>
					<tr><td style='padding:5px 0px;'><?php _e("Last payment" ); ?></td><td><?php echo "<b>$lastpayment</b>"; ?></td></tr>
				<?php } ?>
				
				<?php } ?>
                
                </table>

                <?php    echo "<br/><h4>Revenue generation options <span style='color:red;'>**</span></h2>"; ?>

				<p><input type="radio" name="neuvoojobroll_revenue_option" value="revenue" <?php if ($revenue_option=='revenue') echo 'checked'; ?>> <b>1 to 10 cents per click</b>. Users are sent to the job description page on the Neuvoo website.</p>
                <p><input type="radio" name="neuvoojobroll_revenue_option" value="norevenue" <?php if ($revenue_option=='norevenue') echo 'checked'; ?>> <b>0 cents per click</b>. Users are sent directly to the job description page on the employer website. The Neuvoo brand is not shown anywhere in the process.</p>

                <?php    echo "<br/><h4>" . 'Basic options' . "</h2>"; ?>

				<table>

				<tr><td><?php _e("Language: " ); ?></td><td><select name="neuvoojobroll_language"><option <?php if ($language=='english') echo 'selected'; ?> value='english'>English</option><option <?php if ($language=='french') echo 'selected'; ?> value='french'>French</option></select></td></tr>
                <tr><td><?php _e("Default Location: " ); ?></td><td><input type="text" name="neuvoojobroll_defaultlocation" value="<?php echo $defaultlocation; ?>" size="15"><?php _e(" (ex: Toronto)" ); ?></td></tr>
                <tr><td><?php _e("Default Keywords: " ); ?></td><td><input type="text" name="neuvoojobroll_defaultkeywords" value="<?php echo $defaultkeywords; ?>" size="15"><?php _e(" (ex: Marketing) " ); ?></td></tr>
                <tr><td><?php _e("Default Sorting: " ); ?></td><td><select name="neuvoojobroll_defaultsort"><option <?php if ($defaultsort=='relevance') echo 'selected'; ?> value='relevance'>Sort by Relevance</option><option <?php if ($defaultsort=='date') echo 'selected'; ?> value='date'>Sort by Date</option></select></td></tr>
                <tr><td><?php _e("Number of jobs in the results page: " ); ?></td><td><input type="text" name="neuvoojobroll_numberofjobspage" value="<?php echo $numberofjobspage; ?>" size="5"><?php _e(" (maximum and default is 15)" ); ?></td></tr>
                
                </table>
                
                <?php    echo "<br/><h4>" . 'Look and feel for the search' . "</h2>"; ?>
                
                <table>
                
                <tr><td>Default with logos <input type="radio" name="neuvoojobroll_looknfeel" value="withlogos" <?php if ($looknfeel=='withlogos') echo 'checked'; ?>> </td><td><img style='width:400px;' src='<?php echo WP_PLUGIN_URL; ?>/neuvoo-jobroll/img/withlogos.png'></td></tr>
                
                <tr><td>&nbsp;</td></tr>
                
                <tr><td>Default without logos <input type="radio" name="neuvoojobroll_looknfeel" value="withoutlogos" <?php if ($looknfeel=='withoutlogos') echo 'checked'; ?>> </td><td><img style='width:400px;' src='<?php echo WP_PLUGIN_URL; ?>/neuvoo-jobroll/img/withoutlogos.png'></td></tr>
                
                <tr><td>&nbsp;</td></tr>                
                
                <tr><td>Pure <input type="radio" name="neuvoojobroll_looknfeel" value="pure" <?php if ($looknfeel=='pure') echo 'checked'; ?>> </td><td><img style='width:400px;' src='<?php echo WP_PLUGIN_URL; ?>/neuvoo-jobroll/img/pure.png'></td></tr>
                
                </table>
                
				<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Update Options', 'neuvoojobroll_trdom' ) ?>" />
				</p>
			</form>
			
			
			
			<p><span style='color:red;'>*</span> This email has to be the same email used in your paypal account. When you change your email, your data is reseted including clicks and earnings</p>
			<p><span style='color:red;'>**</span> Payments will be sent the first day of every month via <a href='https://www.paypal.com'>Paypal</a> <a href='https://www.paypal.com'><img style='vertical-align:middle;border:0px;width:30px;' src='<?php echo WP_PLUGIN_URL; ?>/neuvoo-jobroll/img/paypal.jpg'></a>.
This automated payment will be done once you reach the $10 threshold. If you have any questions please contact us at <a href='mailto:wp@neuvoo.com'>wp@neuvoo.com</a></p>
			
		</div>
	
