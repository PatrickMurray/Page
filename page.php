<?php

/*	
 *	Copyright (C) 2013 - Patrick Murray and NULL SOFTWARE, LLC.
 *	
 *	Permission is hereby granted, free of charge, to any person obtaining
 *	a copy of this software and associated documentation files (the
 *	"Software"), to deal in the Software without restriction, including
 *	without limitation the rights to use, copy, modify, merge, publish,
 *	distribute, sublicense, and/or sell copies of the Software, and to
 *	permit persons to whom the Software is furnished to do so, subject to
 *	the following conditions:
 *	
 *	1.	The above copyright notice and this permission notice shall be
 *		included in all copies or substantial portions of the Software.
 *	
 *	2.	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 *		EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 *		MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 *		NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 *		HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 *		WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *		OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 *		DEALINGS IN THE SOFTWARE.
 */

class Page
{
	private $contents = "";
	private $output_bool = True;
	private $compress_bool = False;
	private $compress_fiter = ["<pre", "<textarea"];
	
	function __construct($argv = [])
	{
		$defaults = [
				'output'	=> True,		# Output the contents upon the instance's last call
				'compress'	=> False,		# Remove tab and new line characters if the following are not found in the contents
				'filter'	=> ["<pre", "<textarea"]
			];
		
		try
		{
			# Create an options variable that overrides keys in the defaults array with their value in the argv array
			$options = $argv + $defaults;
			
			if (!$options['output'])
			{
				$this->output_bool = False;
			}
			
			if ($options['compress'])
			{
				$this->compress_bool = True;
			}
			
			$this->compress_filter = $options['filter'];
			
		} catch (Exception $e) {
			# If the programmer provides incorrect types in the argv variable
			throw new Exception('Error: ' . $e);
		}
	}
	
	function open($filepath='layout.html',$append=True)
	{
		try
		{
			$f_handler = fopen($filepath,'r');
			$contents = fread($f_handler,filesize($filepath));
			fclose($f_handler);
			
			if ($append)
			{
				# Add contents to end of document
				$this->contents .= $contents;
			} else {
				# Reassign contents with the file contents
				$this->contents = $contents;
			}
		} catch (Exception $e) {
			# File read error or $append is not a boolean value
			throw new Exception("Darn, an error! " . $e);
		}
	}
	
	function close()
	{
		# Close template
		$this->contents = "";
	}
	
	function replace($name="",$val="",$format=[["<!-- "," -->"], ["<!--","-->"], ["/* "," */"], ["/*","*/"]])
	{
		try
		{
			# For each type of format search the contents for the term and replace it with the given value
			foreach ($format as $comment)
			{
				# Ex: <!-- REPLACE ME -->
				$term = $comment[0] . $name . $comment[1];
				
				$this->contents = str_ireplace($term, $val, $this->contents); # Case-insensative
			}
		} catch (Exception $e) {
			# Murphy's Law: "Anything that can go wrong, will go wrong."
			throw new Exception("Drats! An error: " . $e);
		}
	}
	
	function output()
	{
		try
		{
			$compress = $this->compress_bool;
			foreach ($this->compress_filter as $parameter)
			{
				# Do they even want to compress the page?
				if ($compress)
				{
					# If contents contains a parameter, the compress will be aborted
					if (stristr($this->contents,$parameter) === True)
					{
						// If found, don't compress page
						$compress = False;
					}
				}
			}
			
			# Finally...
			if ($compress)
			{
				foreach (["\t","\n"] as $to_replace)
				{
					# Replace tabs and new lines
					$this->contents = str_ireplace($to_replace, '', $this->contents); // Remove tabs and newlines
				}
			}
		} catch (Exception $e) {
			# Not much can go wrong, but just to be safe...
			throw new Exception("Drats! An error! " . $e);
		}
		return $this->contents;
	}
	
	function __destruct()
	{
		if ($this->output_bool)
		{
			print $this->output();
		}
		$this->close();
	}
}

?>
