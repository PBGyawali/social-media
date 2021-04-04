<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if (isset($_SESSION['count']))
{
$_SESSION['count']++;
echo $_SESSION['count'];

}
else
{
$_SESSION['count']=1;
echo $_SESSION['count'];
}