<!doctype html>
<html <?php language_attributes (); ?>>
<head>
    <meta charset="<?php bloginfo ('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head (); ?>
</head>
<body <?php body_class (is_singular () ? 'singular' : ''); ?>>
<div id="site-primary" class="site-primary">
    <?php get_sidebar (); ?>
    <?php get_template_part ('template-parts/site', 'header') ?>
    <div id="site-content" class="site-content">