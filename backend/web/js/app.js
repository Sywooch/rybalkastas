/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */
$(function () {
    'use strict'

    $('.toggleSidebar').click(function(){
        $('.control-sidebar').toggleClass('control-sidebar-open');
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('.sidebar-menu a').click(function(e){
        if($(this).parent().children('ul').length){
            e.preventDefault();
            $(this).parent().children('ul').toggle();
        }
    });
})
