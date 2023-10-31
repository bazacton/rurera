<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Illuminate\Http\Request;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;

class TextToSpeechController extends Controller
{

    public function getSpeechAudioFilePath($text_to_convert)
    {
        $file_temp_name = $text_to_convert;
        $file_temp_name = strtolower($file_temp_name);
        $file_temp_name = strip_tags($file_temp_name);
        $file_temp_name = str_replace(' ', '-', $file_temp_name);
        $file_temp_name = preg_replace('/[^a-zA-Z0-9_%\[().\]\\/-]/s', '', $file_temp_name);
        $file_temp_name = preg_replace('/[\/\\\\]+/', '-', $file_temp_name);
        $file_temp_name = rtrim($file_temp_name,'.');
        $file_temp_name = str_replace('--', '-', $file_temp_name);
        $file_temp_name = $file_temp_name.'.mp3';
        if(file_exists('speech-audio/'.$file_temp_name)){
            return $file_temp_name;
        }
        $textToSpeechClient = new TextToSpeechClient();
        $input = (new SynthesisInput())
            ->setSsml($text_to_convert);
        //$input->setText($text_to_convert);
        $voice = (new VoiceSelectionParams())
                ->setLanguageCode('en-US')  // Language code (e.g., 'en-US' for English)
                ->setName('en-GB-News-I'); // Specify the name of the voice you want to use


        $audioConfig = new AudioConfig();
        $audioConfig->setAudioEncoding(AudioEncoding::LINEAR16);

        $resp = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
        file_put_contents('speech-audio/'.$file_temp_name, $resp->getAudioContent());
        return $file_temp_name;
    }
}
