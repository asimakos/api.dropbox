<html>

<head>
  <title>DROPBOX ACCOUNT </title>
</head>

<body>

<?php

    require 'vendor/autoload.php';

    use Kunnu\Dropbox\Dropbox;
    use Kunnu\Dropbox\DropboxApp;
    use Kunnu\Dropbox\DropboxFile;

    // Dropbox account information taken from https://www.dropbox.com/developers/apps
    // Removed for security reasons, each user should provide his own credentials

    $client_id="XXXXXXXXXXXXXX";

    $client_secret="YYYYYYYYYYYYYYYYYY";

    $access_token="ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ";

   //Configure Dropbox Application
   $app = new DropboxApp($client_id, $client_secret, $access_token);

   //Configure Dropbox service
   $dropbox = new Dropbox($app);

   //Get account and further information
   $account = $dropbox->getCurrentAccount();

   $accountSpace = $dropbox->getSpaceUsage();

   $account_name=$account->getDisplayName();
   $account_email=$account->getEmail();
   $account_type=$account->getAccountType();
   $account_photo=$account->getProfilePhotoUrl();
   $account_used=$accountSpace['used'];


   echo nl2br("\n <b>DROPBOX  Account  Information </b> \n");

   echo nl2br("Name: $account_name\n Email: $account_email\n Type: $account_type\n Photo url: $account_photo");
   echo nl2br("\n Space used: $account_used (bytes) \n");

   $filepath =__DIR__."/stoixeia.pdf";
   $mode = DropboxFile::MODE_READ;

   $dropboxFile = new DropboxFile($filepath, $mode);
   $fileupload = $dropbox->upload($dropboxFile,"/stoixeia.pdf", ['autorename' => true]);

   $upload_name=$fileupload->getName();

   echo nl2br("\n\n <b> File Uploaded: </b>: $upload_name \n");

   $download = $dropbox->download("/pistwseis.pdf",__DIR__."/pistwseis.pdf");

   $download_metadata = $download->getMetadata();

   $download_name= $download_metadata->getName();

   echo nl2br("\n\n <b> File Downloaded: </b>: $download_name \n");

   $list_contents = $dropbox->listFolder("/");

   $content_items=$list_contents->getItems();

   $total_items=$content_items->all();

   //print_r($total_items);

   echo nl2br("\n <b> Folder items </b> \n");

   $count=0;
   foreach($total_items as $items){

     $count++;
     echo nl2br("$count. Name: $items->name\n Size: $items->size (bytes)\n");
     echo nl2br(" Path: $items->path_display\n Modified: $items->server_modified\n");

   }
?>

</body>

</html>