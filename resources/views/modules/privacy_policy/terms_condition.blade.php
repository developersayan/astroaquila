@extends('layouts.app')

@section('title')
<title>{{__('auth.customer_sign_up_title')}}</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red;
    }
</style>
@endsection

@section('header')
@include('includes.header')
@endsection



@section('body')
<section class=" clearfix pad-terms pad-114">
	<div class="container">
      <div class="common-head">
        <h2>Terms &amp; Conditions </h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
      </div>
      <div class="clearfix"></div>
      <div class="row faq_intro">
        <div class="col-lg-12">
          <div class="privacy-content mb-60">
            <h3>1. Welcome to company Terms &amp; Conditions </h3>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            <h3>2. Lorem Ipsum is simply dummy text</h3>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.Ipsum.</p>
            <h3>3. Lorem Ipsum is simply dummy text</h3>
            <p> It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem </p>
            <h3>4. Lorem Ipsum is simply dummy text</h3>
            <ol>
              <li>Responding to your questions and concerns;</li>
              <li>Sending you administrative messages and information, including messages from instructors and teaching assistants, notifications about changes to our Service, and updates to our agreements;</li>
              <li>Sending push notifications to your wireless device to provide updates and other relevant messages (which you can manage from the “options” or “settings” page of the mobile app);</li>
            </ol>
            <h3>5. Lorem Ipsum is simply dummy text</h3>
            <p> It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
            <ul>
              <li> It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem </li>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.Ipsum.</li>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.Ipsum.</li>
              <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.Ipsum.</li>
            </ul>
            <h3>6. Lorem Ipsum is simply dummy text</h3>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.Ipsum.</p>
          </div>
        </div>
      </div>
      </div>
    </section>
@endsection



@section('footer')
@include('includes.footer')
@endsection


@section('script')

@include('includes.script')
@endsection