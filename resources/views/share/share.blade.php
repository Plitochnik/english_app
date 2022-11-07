@extends('posts.header')

@section('form')
<section class="u-align-center u-clearfix u-section-1" id="sec-571f">
    <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-clearfix u-expanded-width u-gutter-10 u-layout-wrap u-layout-wrap-1">
            <div class="u-gutter-0 u-layout">
                <div class="u-layout-row">
                    <div class="u-size-30">
                        <div class="u-layout-col">
                            <div class="u-align-left u-container-style u-layout-cell u-left-cell u-size-30 u-layout-cell-1">
                                <div class="u-container-layout u-container-layout-1">
                                    <h2 class="u-custom-font u-text u-text-1">Business Center</h2>
                                    <p class="u-custom-font u-text u-text-2">350 5th Ave, New York, NY 10118</p>
                                    <p class="u-custom-font u-text u-text-3">1 212-736-3100</p>
                                    <p class="u-custom-font u-text u-text-4">vitalikplitochnik@gmail.com</p>
                                </div>
                            </div>
                            <div class="u-align-left u-container-style u-layout-cell u-left-cell u-size-30 u-layout-cell-2">
                                <div class="u-container-layout u-valign-top u-container-layout-2">
                                    <div class="u-form u-form-1">
                                        <form action="//publish.nicepage.com/Form/Process" method="POST"
                                              class="u-clearfix u-form-spacing-10 u-form-vertical u-inner-form"
                                              style="padding: 10px" source="email" name="form-5">
                                            <div class="u-form-group u-form-name u-label-none">
                                                <label for="name-5359" class="u-label">Name</label>
                                                <input type="text" placeholder="Name" id="name-5359" name="name"
                                                       class="u-border-1 u-border-grey-30 u-input u-input-rectangle"
                                                       required="">
                                            </div>
                                            <div class="u-form-email u-form-group u-label-none">
                                                <label for="email-5359" class="u-label">Email</label>
                                                <input type="email" placeholder="Email" id="email-5359" name="email"
                                                       class="u-border-1 u-border-grey-30 u-input u-input-rectangle"
                                                       required="">
                                            </div>
                                            <div class="u-form-group u-form-message u-label-none">
                                                <label for="message-5359" class="u-label">Address</label>
                                                <textarea placeholder="Address" rows="4" cols="50" id="message-5359"
                                                          name="message"
                                                          class="u-border-1 u-border-grey-30 u-input u-input-rectangle"
                                                          required=""></textarea>
                                            </div>
                                            <div class="u-form-group u-form-submit">
                                                <a href="#"
                                                   class="u-btn u-btn-submit u-button-style u-custom-font u-btn-1">Submit</a>
                                                <input type="submit" value="submit" class="u-form-control-hidden">
                                            </div>
                                            <div class="u-form-send-message u-form-send-success">Thank you! Your message
                                                has been sent.
                                            </div>
                                            <div class="u-form-send-error u-form-send-message">Unable to send your
                                                message. Please fix errors then try again.
                                            </div>
                                            <input type="hidden" value="" name="recaptchaResponse">
                                            <input type="hidden" name="formServices"
                                                   value="ac7fc5b9e8407dc7df61336b59540106">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="u-size-30">
                        <div class="u-layout-col">
                            <div class="u-align-left u-container-style u-layout-cell u-right-cell u-size-60 u-layout-cell-3">
                                <div class="u-container-layout u-container-layout-3">
                                    <div class="u-expanded u-grey-light-2 u-map">
                                        <div class="embed-responsive">
                                            <iframe class="embed-responsive-item"
                                                    src="//maps.google.com/maps?output=embed&amp;q=Manhattan%2C%20New%20York&amp;z=10&amp;t=m"
                                                    data-map="JTdCJTIyYWRkcmVzcyUyMiUzQSUyMk1hbmhhdHRhbiUyQyUyME5ldyUyMFlvcmslMjIlMkMlMjJ6b29tJTIyJTNBMTAlMkMlMjJ0eXBlSWQlMjIlM0ElMjJyb2FkJTIyJTJDJTIybGFuZyUyMiUzQSUyMiUyMiU3RA=="></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection





{{--@include('posts.footer')--}}
