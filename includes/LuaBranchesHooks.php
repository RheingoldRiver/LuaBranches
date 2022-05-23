<?php

class LuaBranchesHooks {
	public function onScribuntoGetInvokeOptions(&$options, $frame, $args) {
		foreach($args as $arg) {
			$parts = explode('=', $frame->expand($arg), 2);
			if (trim($parts[0]) === '_branch') {
				$options['branch'] = trim($parts[1]);
				return true;
			}
		}
		$options['branch'] = null;
		return true;
	}

	public function onScribuntoLoadPackageModuleTitle(&$title, $name, $options) {
		$branch = $options['branch'];
		if ( $branch === null ) return;
		$branchPattern = $GLOBALS['wgLuaBranchesBranchPattern'];
		$branchedName = $name . str_replace('%s', $branch, $branchPattern);
		$branchedTitle = Title::newFromText( $branchedName );
		$title = $branchedTitle->exists() ? $branchedTitle : $title;
		return true;
	}

}