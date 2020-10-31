@extends('errors::layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __(($exception->getMessage() ?: 'Server Error') . ' Please email us at contact@treiner.co if you see this error.'))
