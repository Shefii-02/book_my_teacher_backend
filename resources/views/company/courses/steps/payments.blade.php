<form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-title">
        <h2 id="drawer-right-label"
            class="text-gray-400 rounded-lg text-lg text-sm absolute top-2.5  inline-flex items-center justify-center">
            <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            Pricing & Discount
        </h2>
    </div>

    <div class="form-body mt-8">
        <div class="grid gap-6 mb-6 md:grid-cols-2 mt-5">
            <input type="hidden" class="d-none" value="{{ $course->course_identity }}" name="course_identity" />
            <!-- Actual Price -->
            <div>
                <label class="block mb-2 text-sm font-medium">Actual Price</label>
                <input type="number" step="0.01" id="actual_price" name="actual_price"
                    value="{{ old('actual_price', $course->actual_price ?? 0) }}"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </div>

            <!-- Discount Type -->
            <div>
                <label class="block mb-2 text-sm font-medium">Discount Type</label>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-1">
                        <input type="radio" class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                            name="discount_type" value="fixed" id="discount_type_fixed"
                            {{ old('discount_type', $course->discount_type ?? 'fixed') == 'fixed' ? 'checked' : '' }}>
                        <span class="text-sm">Fixed</span>
                    </label>
                    <label class="flex items-center gap-1">
                        <input type="radio" class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                            name="discount_type" value="percentage" id="discount_type_percentage"
                            {{ old('discount_type', $course->discount_type ?? '') == 'percentage' ? 'checked' : '' }}>
                        <span class="text-sm">Percentage</span>
                    </label>
                </div>
            </div>

            <!-- Discount Amount -->
            <div>
                <label class="block mb-2 text-sm font-medium discount_type">Discount Amount</label>
                <input type="number" step="0.01" id="discount_amount" name="discount_amount"
                    value="{{ old('discount_amount', $course->discount_amount ?? 0) }}"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <!-- Coupon Available -->
            <div>
                <label class="block mb-2 text-sm font-medium">Coupon Available</label>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-1">
                        <input type="radio" class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                            name="coupon_available" value="1"
                            {{ old('coupon_available', $course->coupon_available ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="text-sm">Yes</span>
                    </label>
                    <label class="flex items-center gap-1">
                        <input type="radio" class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                            name="coupon_available" value="0"
                            {{ old('coupon_available', $course->coupon_available ?? '') == '0' ? 'checked' : '' }}>
                        <span class="text-sm">No</span>
                    </label>
                </div>
            </div>

            <!-- Tax -->
            <div>
                <span for="tax" class="block mb-2 text-sm font-medium">Tax</span>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-1">
                        <input type="radio" class="bg-gray-100 border-gray-300 focus:ring-blue-500 tax_type"
                            name="is_tax" value="included" id="tax_included"
                            {{ old('is_tax', $course->is_tax ?? 'included') == 'included' ? 'checked' : '' }}>
                        <span class="text-sm">Included</span>
                    </label>
                    <label class="flex items-center gap-1">
                        <input type="radio" class="bg-gray-100 border-gray-300 focus:ring-blue-500 tax_type"
                            name="is_tax" value="excluded" id="tax_excluded"
                            {{ old('is_tax', $course->is_tax ?? '') == 'excluded' ? 'checked' : '' }}>
                        <span class="text-sm">Excluded</span>
                    </label>
                </div>
                <div id="tax_percentage_div"
                    style="{{ $course && $course->is_tax == 'included' ? 'display: none' : '' }}">
                    <div class="flex mb-6">
                        <input type="number" step="0.01" id="tax_percentage" name="tax_percentage"
                            placeholder="Tax Percentage (e.g., 18)"
                            value="{{ old('tax_percentage', $course->tax_percentage ?? 0) }}"
                            class="mt-2 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2.5">
                        <div class=" inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            %
                        </div>
                    </div>
                </div>
            </div>

            <!-- Discount Validity -->
            <div>
                <label class="block mb-2 text-sm font-medium">Discount Validity</label>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-1">
                        <input type="radio" class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                            name="discount_validity" value="unlimited"
                            {{ old('discount_validity', $course->discount_validity ?? 'unlimited') == 'unlimited' ? 'checked' : '' }}>
                        <span class="text-sm">Unlimited</span>
                    </label>
                    <label class="flex items-center gap-1">
                        <input type="radio" class="bg-gray-100 border-gray-300 focus:ring-blue-500"
                            name="discount_validity" value="limited"
                            {{ old('discount_validity', $course->discount_validity ?? '') == 'limited' ? 'checked' : '' }}>
                        <span class="text-sm">Limited</span>
                    </label>
                </div>

            </div>

            <!-- Discount Validity End Date -->
            <div id="discount_validity_end_container">
                <label class="block mb-2 text-sm font-medium">Discount Valid Until</label>
                <input type="date" name="discount_validity_end"
                    value="{{ old('discount_validity_end', $course->discount_validity_end ?? '') }}"
                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-2 mt-5">
            <!-- Net Price (auto-calculated) -->
            <div>
                <label class="block mb-2 text-sm font-medium">Net Price (After Discount & Tax)</label>
                <input type="number" step="0.01" id="net_price" name="net_price"
                    value="{{ old('net_price', $course->net_price ?? 0) }}" readonly
                    class="border border-gray-300 bg-gray-100 text-sm rounded-lg block w-full p-2.5">
            </div>

            <!-- Gross Price (optional hidden if tax excluded) -->
            <div id="gross_price_container">
                <label class="block mb-2 text-sm font-medium">Gross Price (Before Tax)</label>
                <input type="number" step="0.01" id="gross_price" name="gross_price"
                    value="{{ old('gross_price', $course->gross_price ?? 0) }}" readonly
                    class="border border-gray-300 bg-gray-100 text-sm rounded-lg block w-full p-2.5">
            </div>
        </div>

    </div>
    <!-- Submit -->
    <div class="my-2 text-center md:col-span-2">
        <input type="submit"
            class="px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 rounded-lg"
            name="pricing_form" value="{{ $course ? 'Update' : 'Create' }}">
    </div>

</form>
<script>
    $(document).ready(function() {
        function calculatePrices() {
            let actual = parseFloat($('#actual_price').val()) || 0;
            let discountAmount = parseFloat($('#discount_amount').val()) || 0;
            let taxPercent = parseFloat($('#tax_percentage').val()) || 0;
            let discountType = $('input[name="discount_type"]:checked').val();
            let taxType = $('input[name="is_tax"]:checked').val();

            let discountedPrice = actual;

            if (discountType === 'fixed') {
                discountedPrice = actual - discountAmount;
                $('.discount_type').text('Discount Amount');
            } else if (discountType === 'percentage') {
                discountedPrice = actual - (actual * discountAmount / 100);
                $('.discount_type').text('Discount Percentage');
            }

            let gross = discountedPrice;
            let net = discountedPrice;

            if (taxType === 'excluded') {
                net = discountedPrice + (discountedPrice * taxPercent / 100);
            }

            $('#gross_price').val(gross.toFixed(2));
            $('#net_price').val(net.toFixed(2));
        }

        function toggleValidityDate() {
            let validity = $('input[name="discount_validity"]:checked').val();
            if (validity === 'limited') {
                $('#discount_validity_end_container').show();
            } else {
                $('#discount_validity_end_container').hide();
            }
        }

        function toggleIsTax() {
            let is_tax = $('input[name="is_tax"]:checked').val();
            if (is_tax === 'excluded') {
                $('#tax_percentage_div').show();
            } else {
                $('#tax_percentage_div').hide();
            }
        }

        // Events
        $('#actual_price, #discount_amount, #tax_percentage').on('input', calculatePrices);
        $('input[name="discount_type"], input[name="is_tax"]').on('change', calculatePrices);
        $('input[name="discount_validity"]').on('change', toggleValidityDate);
        $('input[name="is_tax"]').on('change', toggleIsTax);

        // Init
        calculatePrices();
        toggleValidityDate();
    });
</script>
