<?php
echo "Xxx";
$connection = ssh2_connect('sftp.enseval.com', 990);
ssh2_auth_password($connection, 'taisho', 'qazwsx212!');
echo "Xxx2";

$sftp = ssh2_sftp($connection);
if (! $sftp)
{
    echo "Could not initialize SFTP subsystem.";
}			

$stream = fopen('ssh2.sftp://' . intval($sftp) . '/taisho/nasional', 'r');

if (! $stream)
{
    echo "Could not open file: $remote_file";
}			
			
$data_to_send = @file_get_contents('/home/crmtaisho/public_html/assets/sftp');
        if ($data_to_send === false)
		{
            echo "Could not open local file: /home/crmtaisho/public_html/assets/sftp";
		}	

        if (@fwrite($stream, $data_to_send) === false)
		{
            echo "Could not send data from file: /home/crmtaisho/public_html/assets/sftp";
		}	

        fclose($stream);			

?>