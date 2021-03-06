GET CONTENT FROM GRAVATAR
========

This is specially created PHP class for Gravatar API. This class provides secure data access for www.Gravatar.com.
This class can be used for your custom webpage but you can include in WordPress, Joomla or other CMS systems.
It's easy to use.

EXAMPLE OF USE:
========
Gravatar use your email address to recognize unique avatar. Like default you can give default image to gravatar if your profile don't have image or is your image only for adults.

    $gravatar=new gravatar('example@yourmail.com', 'http://mydomain.com/image/DEFAULT-IMAGE.jpg');
	
	$gravatar->image($image_size);		// Return image url
	$gravatar->QRcode($image_size);	    // Return QR Code url
	$gravatar->vCard();	    		// Return VCF/vCard
	$gravatar->json(); 	    		// Return objects
	$gravatar->xml(); 				// Return xml data

SETUP AND LOAD YOUR GRAVATAR WITH EXAMPLE
========

    $gravatar=new gravatar('example@yourmail.com', 'http://creativform.com/www.creativform.com.jpg');

GET IMAGE
========
Standard approach:

    echo '<img src="'.$gravatar->image(400).'">';

Access to secure image:

    echo '<img src="'.$gravatar->image(400,true).'">';
    
Access to non-secure image with max rating:

    echo '<img src="'.$gravatar->image(400,false,'r').'">';
    
GET QR CODE
========

    echo '<img src="'.$gravatar->QRcode(400).'">';
    
GET QR VCF/vCard
========
You can setup headers to download your vCard using this:

    $gravatar->vCard();
    
GET JSON
========
If you whant to use all data from your gravatar profile you can use json() to make objects and you can handle with it.

    $json=$gravatar->json();
    echo $json->profileUrl;
    
GET XML
========
If you whant to use all data from your gravatar profile using XML, this is easy.

    echo $gravatar->xml();
