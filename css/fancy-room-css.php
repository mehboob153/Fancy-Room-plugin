<style>
.social{ 
				position:relative;
				background-color:<?php echo get_option('background_color')!=''?'#'.get_option('background_color'):'#F3F1F2'; ?>;
				background-image:url('<?php echo plugins_url().'/Fancy-room-plugin/images/funny-room.png'; ?>');
				background-repeat:no-repeat;
				bacground-position:center;
				width:1160px;
				height:660px;
				z-index:100;
				margin: auto ;
		}
		#facebook_url,#twitter_url,#contact_url,#helpdesk_url,#linkedin_url,#faq_url,#skype_url,#instagram_url,#money_url,#video_url,
		#pinterest_url,#contest_url,#testimonial_url,#google_url,#gallery_url,#press_url,#blog_url,#calender_url,#pics_url,#notes_url,#audio_url{
			position:absolute;
		}
		
		#facebook_url{
			height: 0;
			left: 454px;
			top: 20px;
			width: 0;
		}
		#facebook_url a{
			display: block;
			height: 85px;
			width: 29px;
		}
		#twitter_url{
			height: 0;
			left: 28px;
			top: 104px;
			width: 0;
		}
		#twitter_url a{
			display: block;
			height: 250px;
			width: 110px;
		}
		#contact_url{
			height: 0;
			left: 578px;
			top: 351px;
			width: 0;
		}
		#contact_url a{
			display: block;
			height: 65px;
			width: 64px;
		}
		#helpdesk_url{
			height: 0;
			left: 363px;
			top: 19px;
			width: 0;
		}
		#helpdesk_url a{
			display: block;
			height: 87px;
			width: 29px;
		}
		#linkedin_url{
			height: 0;
			left: 392px;
			top: 16px;
			width: 0;
		}
		#linkedin_url a{
			display: block;
			height: 92px;
			width: 28px;
		}
		#faq_url{
			height: 0;
			left: 363px;
			top: 19px;
			width: 0;
		}
		#faq_url a{
			display: block;
			height: 87px;
			width: 29px;
		}
		#skype_url{
			height: 0;
			left: 420px;
			top: 28px;
			width: 0;
		}
		#skype_url a{
			display: block;
			height: 79px;
			width: 32px;
		}
		#instagram_url{
			height: 0;
			left: 976px;
			top:  349px;
			width: 0;
		}
		#instagram_url a{
			display: block;
			height: 65px;
			width: 66px;
		}
		#money_url{
			height: 0;
			left: 127px;
			top: 378px;
			width: 220;
		}
		#money_url a{
			display: block;
			height: 57px;
			width: 83px;
		}
		#video_url{
			height: 0;
			left: 590px;
			top: 54px;
			width: 0;
		}
		#video_url a{
			display: block;
			height: 255px;
			width: 431px;
		}
		#pinterest_url{
			height: 0;
			left: 257px;
			top: 188px;
			width: 0;
		}
		#pinterest_url a{
			display: block;
			height: 53px;
			width: 47px;
		}
		#contest_url{
			height: 0;
			left: 251px;
			top: 24px;
			width: 0;
		}
		#contest_url a{
			display: block;
			height: 83px;
			width: 54px;
		}
		#testimonial_url{
			height: 0;
			left: 185px;
			top: 26px;
			width: 0;
		}
		#testimonial_url a{
			display: block;
			height: 81px;
			width: 62px;
		}
		#google_url{
			height: 0;
			left: 316px;
			top: 184px;
			width: 0;
		}
		#google_url a{
			display: block;
			height: 45px;
			width: 47px;
		}
		#gallery_url{
			height: 0;
			left: 372px;
			top: 181px;
			width: 0;
		}
		#gallery_url a{
			display: block;
			height: 46px;
			width: 63px;
		}
		#press_url{
			height: 0;
			left: 222px;
			top: 349px;
			width: 0;
		}
		#press_url a{
			display: block;
			height: 43px;
			width: 102px;
		}
		#blog_url{
			height: 0;
			left: 341px;
			top: 288px;
			width: 0;
		}
		#blog_url a{
			display: block;
			height: 76px;
			width: 102px;
		}
		#calender_url{
			height: 0;
			left: 263px;
			top: 253px;
			width: 0;
		}
		#calender_url a{
			display: block;
			height: 39px;
			width: 39px;
		}
		#pics_url{
			height: 0;
			left: 324px;
			top: 237px;
			width: 0;
		}
		#pics_url a{
			display: block;
			height: 51px;
			width: 51px;
		}
		#notes_url{
			height: 0;
			left: 390px;
			top: 240px;
			width: 0;
		}
		#notes_url a{
			display: block;
			height: 32px;
			width: 33px;
		}
		#audio_url{
			height: 0;
			left: 810px;
			top: 417px;
			width: 0;
		}
		#audio_url a{
			display: block;
			height: 112px;
			width: 216px;
		}
		.showcase
		{
			position: relative;
			margin: auto;
			top:65px;
			left:225px;
		}
		.showcase-arrow-previous
		{
			right: 39px;
			top: 452px;
			transform:rotate(-18deg);
			-ms-transform:rotate(-18deg); /* IE 9 */
			-webkit-transform:rotate(-18deg); /* Safari and Chrome */
		}

		.showcase-arrow-next
		{
			right: 37px;
			top: 461px;
			transform:rotate(160deg);
			-ms-transform:rotate(160deg); /* IE 9 */
			-webkit-transform:rotate(160deg); /* Safari and Chrome */
		}
</style>