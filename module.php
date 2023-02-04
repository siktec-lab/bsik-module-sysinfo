<?php
/******************************************************************************/
// Created by: Shlomo Hassid.
// Release Version : 1.0.1
// Creation Date: 17/05/20202
// Copyright 2020, Shlomo Hassid.
/******************************************************************************/
/*****************************      Changelog       ****************************
1.0.1:
    ->initial, Creation
*******************************************************************************/
require_once BSIK_AUTOLOAD;

use \Bsik\Builder\Components;
use \Bsik\Module\Modules;
use \Bsik\Module\Module;
use \Bsik\Module\ModuleEvent;
use \Bsik\Module\ModuleView;
use \Bsik\Privileges as Priv;
use \Bsik\Objects\SettingsObject;

/****************************************************************************/
/*******************  local Includes    *************************************/
/****************************************************************************/
//require_once "includes".DS."components.php";


/****************************************************************************/
/*******************  required privileges for module / views    *************/
/****************************************************************************/
$module_policy = new Priv\RequiredPrivileges();
$module_policy->define(
    new Priv\PrivAccess(manage : true)
);

/****************************************************************************/
/*******************  Register Module  **************************************/
/****************************************************************************/
Modules::register_module_once(new Module(
    name          : "sysinfo",
    privileges    : $module_policy,
    views         : ["sysinfo"],
    default_view  : "sysinfo",
    settings    : new SettingsObject([
        "title"         => "System Information",
        "description"  => "Useful information on your system",
    ])
)); 

/****************************************************************************/
/*******************  View - dashboard  *************************************/
/****************************************************************************/
Modules::module("sysinfo")->register_view(
    view : new ModuleView(
        name        : "sysinfo",
        privileges  : null,
        settings    : new SettingsObject([
            "title"         => "Server View",
            "description"  => "Useful information on your system",
        ])
    ),
    render      : function() {

        /** @var Module $this */
        
        //Return Templated:
        return <<<HTML
            <div class='container'>
                <p>Hello From SysInfo</p>
            </div>
        HTML;

    }
);


/****************************************************************************/
/*******************  Event - uninstall  ************************************/
/****************************************************************************/
Modules::module("sysinfo")->register_event(
    on_events : ["me-install", "me-uninstall", "me-activate", "me-deactivate"],
    event_method : function(string $event) {
        $this->page::log("info", "test events", ["module" => $this->module_name, "event" => $event]);
    }
);
