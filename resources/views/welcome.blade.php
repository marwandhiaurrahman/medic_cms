@include('vendor.medic.partials.header')

@include('vendor.medic.partials.navigation')

@include('vendor.medic.partials.hero_slider')

@include('vendor.medic.partials.call_action')

@include('vendor.medic.partials.about')

@include('vendor.medic.partials.abaout_tab')

@include('vendor.medic.partials.service_filterable')

@include('vendor.medic.partials.team')

@include('vendor.medic.partials.testimonial')

<!-- Contact Section -->
<section class="appoinment-section section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                @@include('blocks/accordions.htm')
            </div>
            <div class="col-lg-6">
                @@include('blocks/contact-area.htm')
            </div>
        </div>
    </div>
</section>
<!-- End Contact Section -->

@include('vendor.medic.partials.footer_block')

@include('vendor.medic.partials.footer')
