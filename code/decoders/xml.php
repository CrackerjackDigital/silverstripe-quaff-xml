<?php
namespace Quaff\Transports\Readers;

/**
 * TODO COMPLETE AND TEST CODE COPY-PASTED FROM RESPONSE
 */

use Quaff\Exceptions\Transport as Exception;
use Quaff\Transports\Transport;

trait xml {
	
	/**
	 * Return provided text as an xml DOM Document.
	 *
	 * @return \DOMDocument
	 * @throws Exception
	 */
	public function decode($xmlString) {
		libxml_use_internal_errors(true);
		libxml_clear_errors();
		
		$doc = new \DOMDocument();
		if (!$doc->loadXML($xmlString, $this->get_config_setting('decode_options', Transport::content_type('XML')))) {
			
			$message = "Failed to load document from response raw data";
			if ($error = libxml_get_last_error()) {
				$message .= ": '$error'";
			}
			throw new Exception($message);
		}
		$xpath = new \DOMXPath($doc);
		if ($itemPath = $this->getEndpoint()->getItemPath()) {
			return $xpath->query($itemPath);
		} else {
			return $xpath->query('/');
		}
	}
	
}