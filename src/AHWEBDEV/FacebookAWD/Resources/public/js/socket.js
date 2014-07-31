/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var FacebookAWDSocket = function() {
    var socketUri = "http://localhost:8081";
    var socket = io(socketUri);
    return socket;
};

var socket = new FacebookAWDSocket();
