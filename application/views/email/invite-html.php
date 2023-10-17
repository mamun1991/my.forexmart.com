<html>
<body>

<div class="main-wrapper" style="margin: 0 auto;width: 615px;">
    <?php $this->load->view('email/_email_header')?>
    <p class="greetings" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;">  <img style="width: 100%" src="<?=base_url() ?>assets/images/findfriends3.png"></p>

   <!-- <h1 class="h1" style="margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;"><?/*=$subject*/?></h1>-->
    <div class="content-grid" style="margin: 0 auto;padding: 15px;box-sizing: border-box; padding-bottom: 0px;">

        <p class="greetings" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;">Hi  <?=$name; ?>,</p>

        <p style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;">Greetings!</p>
        <p class="letter-body" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;line-height: 19px;">

            If you’re looking for a Forex broker, it is my pleasure to suggest ForexMart to you, my most trusted and reliable broker. Let me give short review of this Company to make the things clear for you.


             </p>



        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;"> Since its inception, ForexMart has already endeavored to give its clients the following:</p>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">

            <ul style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
                <li> Most Popular Trading Platform - You can facilitate hundreds of trades daily with its glitch-free, user-friendly software. </li>
                <li>Competitive Rates - You can stand out in the currency market by ForexMart’s tight spreads and updated real-time quotes. </li>
                <li>Friendly Customer Support - Their friendly and approachable customer support will surely help you get through the verification process easily.</li>
            </ul>

        </p>


            <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;"> In addition to the mentioned features above, ForexMart has also aimed to give trading bonuses. You can open a real account and get 30% or even 50% bonus every time you make a deposit!
        </p>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;"> Bonus sum and period is not limited!
        </p>

        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;"> Here’s to hoping that I will see you embark on your trading experience and unlock limitless opportunities with ForexMart, like me.
        </p>

        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;"> Many many more features are waiting for you at www.forexmart.com.
        </p>

        <center>  <p style="font-size: 14px;font-family: Arial sans-serif;font-weight: 400;color: #555;margin: 25px 0px 30px 0px;text-align: justify;"><a href="https://www.forexmart.com/register?id=<?=$ref_number?>" style="background: none repeat scroll 0 0 #2988ca; border: 1px solid #2988ca; color: #fff; font-family: Arial; font-size: 15px; font-weight: 500; padding: 8px 25px; transition: all 0.3s ease 0s; text-decoration: none;">
                    Open an Account Now </a></p> </center>

        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">I wish you a successful trading experience!</p>


        <p class="closing" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;line-height: 19px;padding-bottom: 15px;">
            Thank you for attention.<br style="margin: 0 auto;">
            With best regards,<br style="margin: 0 auto;">
            <span style="margin: 0 auto;font-weight: 600;color: #2988ca;"><?php echo $this->session->userdata('full_name');?></span>
        </p>





    </div>

    <?php $this->load->view('email/_email_footer')?>

</div>

</body>
</html>