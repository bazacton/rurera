<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

class GitController extends Controller
{
    public function runGitCommands()
    {
		$token = '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';  // Replace with your actual token
		$repoUrl = 'https://' . $token . '@github.com/bazacton/mainrepo.git';

		// Step 1: Perform a git pull in the 'rurera-temp-git' directory
		exec('cd.. && cd.. && cd rurera-resources && git pull', $output, $return_var);
		if ($return_var !== 0) {
			//pre($output);
			//return response()->json(['message' => 'Git pull failed', 'output' => $output], 500);
		}

		// Step 2: Use Robocopy to move files from the temporary directory to the current directory (excluding .git folder)
		//exec('robocopy rurera-temp-git ../ /E /MOV /XD .git');
		exec('rurera-resources /rurera /E /MOVE /XD .git', $output1, $return_var1);
		if ($return_var1 !== 0) {
			pre($output1);
			return response()->json(['message' => 'Robocopy move failed', 'output' => $output1], 500);
		}



		// Step 3: Remove all files and folders inside 'rurera-temp-git' except for the '.git' folder
		//exec('robocopy rurera-temp-git rurera-temp-git /MIR /XD .git', $output, $return_var);  // This will mirror and clean the directory
		if ($return_var !== 0) {
			return response()->json(['message' => 'Failed to clean up directory except for .git', 'output' => $output], 500);
		}

		// Optionally Step 4: Delete the temp folder if needed (keeping .git if you want to pull next time)
		// exec('rmdir /S /Q rurera-temp-git');

		// Return success message
		return response()->json(['message' => 'Repository pulled, files moved, and cleaned successfully.']);

    }
	
}
