@extends('layouts.myapp')
@section('content')
<div class="mx-auto max-w-screen-xl bg-white rounded-md p-6 m-8">
    <div class="flex justify-between md:flex-row flex-col">
        {{-- -------------------------------------------- left -------------------------------------------- --}}
        <div class="md:w-2/3 md:border-r border-gray-800 p-2">
            <h2 class="ms-4 max-w-full font-car md:text-6xl text-4xl">
                {{ $car->brand }} {{ $car->model }} {{ $car->engine }}
            </h2>

            <div class="flex items-end mt-8 ms-4">
                <h3 class="font-car text-gray-500 text-2xl">Price per day:</h3>
                <p>
                    <span class="text-3xl font-bold text-pr-400 ms-3 me-1 border border-pr-400 p-2 rounded-md">
                        {{ $car->price_per_day }} ₱
                    </span>
                    @if($car->reduce > 0)
                    <span class="text-lg font-medium text-red-500 line-through">
                        {{ intval(($car->price_per_day * 100) / (100 - $car->reduce)) }} ₱
                    </span>
                    @endif
                </p>
            </div>

            <div class="flex items-center justify-around mt-10 me-10">
                <div class="w-1/5 md:w-1/3 h-[0.25px] bg-gray-500"></div>
                <p>Reservation Details</p>
                <div class="w-1/5 md:w-1/3 h-[0.25px] bg-gray-500"></div>
            </div>

            <div class="px-6 md:me-8">
                <form id="reservation_form" action="{{ route('car.reservationStore', ['car' => $car->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        {{-- Full Name --}}
                        <div class="sm:col-span-3">
                            <label for="full-name" class="block text-sm font-medium leading-6 text-gray-900">Full Name</label>
                            <div class="mt-2">
                                <input type="text" name="full-name" id="full-name" value="{{ $user->name }}"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 
                                    placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                            <div class="mt-2">
                                <input type="text" name="email" id="email" value="{{ $user->email }}"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 
                                    placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('email')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Start Date --}}
                        <div class="sm:col-span-3">
                            <label for="start_date" class="block text-sm font-medium leading-6 text-gray-900">Start Date</label>
                            <div class="mt-2">
                                <input type="date" name="start_date" id="start_date" min="{{ date('Y-m-d') }}"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 
                                    placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        {{-- End Date --}}
                        <div class="sm:col-span-3">
                            <label for="end_date" class="block text-sm font-medium leading-6 text-gray-900">End Date</label>
                            <div class="mt-2">
                                <input type="date" name="end_date" id="end_date" min="{{ date('Y-m-d') }}"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 
                                    placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        {{-- Hidden field for combined dates --}}
                        <input type="hidden" name="reservation_dates" id="reservation_dates">
                        {{-- Driver's License Upload --}}
                        <div class="sm:col-span-6">
                            <label for="drivers_license" class="block text-sm font-medium leading-6 text-gray-900">Upload Valid Driver's License <span class="text-red-500">*</span></label>
                            <div class="mt-2">
                                <input type="file" name="drivers_license" id="drivers_license" accept="image/*,application/pdf" required
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pr-400 sm:text-sm sm:leading-6">
                            </div>
                            @error('drivers_license')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Submit (Desktop) --}}
                    <div class="mt-12 md:block hidden">
                        <button type="submit" id="submit_button"
                            class="text-white bg-pr-400 p-3 w-full rounded-lg font-bold hover:bg-black shadow-xl hover:shadow-none disabled:opacity-50 disabled:cursor-not-allowed">
                            Reserve Now
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- -------------------------------------------- right -------------------------------------------- --}}
        <div class="md:w-1/3 flex flex-col justify-start items-center">
            <div class="relative mx-3 mt-3 flex h-[200px] w-3/4 overflow-hidden rounded-xl shadow-lg">
                <img loading="lazy" class="h-full w-full object-cover" src="{{ $car->image }}" alt="product image" />
                @if($car->reduce > 0)
                <span class="absolute w-24 h-8 py-1 top-0 left-0 m-2 rounded-full bg-pr-400 px-2 text-center text-sm font-medium text-white">
                    {{ $car->reduce }}% OFF
                </span>
                @endif
            </div>
            <p class="ms-4 max-w-full font-car text-xl mt-3 md:block hidden">
                {{ $car->brand }} {{ $car->model }} {{ $car->engine }}
            </p>

            <div class="mt-3 ms-4 md:block hidden">
                <div class="flex items-center">
                    @for ($i = 0; $i < $car->stars; $i++)
                        <svg aria-hidden="true" class="h-4 w-4 text-pr-300" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 
                            1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 
                            1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 
                            0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 
                            00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 
                            0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @endfor
                    <span class="mr-2 ml-3 rounded bg-pr-300 px-2.5 py-0.5 text-sm font-semibold">
                        {{ $car->stars }}.0
                    </span>
                </div>
            </div>

            <div class="w-full mt-8 px-8">
                <div id="availability_status" class="mb-6 text-center hidden">
                    <p class="text-lg font-medium">
                        <span id="availability_icon" class="mr-2">⚪</span>
                        <span id="availability_text">Select dates to check availability</span>
                    </p>
                </div>

                <p id="duration" class="font-car text-gray-600 text-lg mb-4">
                    Duration:
                    <span class="mx-2 font-car text-md font-medium text-gray-700 border border-pr-400 p-2 rounded-md">-- days</span>
                </p>

                <p id="total-price" class="font-car text-gray-600 text-lg">
                    Total Price:
                    <span class="mx-2 font-car text-md font-medium text-gray-700 border border-pr-400 p-2 rounded-md">-- ₱</span>
                </p>
            </div>

            {{-- Submit (Mobile) --}}
            <div class="mt-12 w-full px-8 md:hidden">
                <button type="submit" form="reservation_form" id="mobile_submit_button"
                    class="text-white bg-pr-400 p-3 w-full rounded-lg font-bold hover:bg-black shadow-xl hover:shadow-none disabled:opacity-50 disabled:cursor-not-allowed">
                    Reserve Now
                </button>
            </div>
        </div>
    </div>

    {{-- Toast for Error --}}
    @if (session('error'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "{{ session('error') }}"
            });
        </script>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const reservationDatesInput = document.getElementById('reservation_dates');
    const durationSpan = document.querySelector('#duration span');
    const totalPriceSpan = document.querySelector('#total-price span');
    const submitButtons = document.querySelectorAll('#submit_button, #mobile_submit_button');
    const availabilityStatus = document.getElementById('availability_status');
    const availabilityIcon = document.getElementById('availability_icon');
    const availabilityText = document.getElementById('availability_text');
    const pricePerDay = {{ $car->price_per_day }};

    function updateDatesAndCalculations() {
        const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
        const endDate = endDateInput.value ? new Date(endDateInput.value) : null;

        if (startDate && endDate) {
            // Update hidden input for form submission
            reservationDatesInput.value = `${startDateInput.value} to ${endDateInput.value}`;

            // Calculate duration and price
            const duration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
            const totalPrice = duration * pricePerDay;

            if (duration > 0) {
                durationSpan.textContent = `${duration} days`;
                totalPriceSpan.textContent = `${totalPrice} ₱`;

                // Check availability
                checkAvailability(startDateInput.value, endDateInput.value);
            } else {
                resetCalculations();
                disableSubmitButtons();
                showAvailabilityMessage('⚠️', 'End date must be after start date', 'text-yellow-500');
            }
        } else {
            resetCalculations();
            disableSubmitButtons();
            hideAvailabilityStatus();
        }
    }

    function checkAvailability(startDate, endDate) {
        fetch(`/check-availability/{{ $car->id }}?start=${startDate}&end=${endDate}`)
            .then(response => response.json())
            .then(data => {
                if (data.available) {
                    showAvailabilityMessage('🟢', 'Car is available for these dates!', 'text-green-500');
                    enableSubmitButtons();
                } else {
                    showAvailabilityMessage('🔴', 'Car is not available for these dates', 'text-red-500');
                    disableSubmitButtons();
                }
            })
            .catch(() => {
                showAvailabilityMessage('⚠️', 'Could not check availability', 'text-yellow-500');
                disableSubmitButtons();
            });
    }

    function showAvailabilityMessage(icon, text, colorClass) {
        availabilityStatus.classList.remove('hidden');
        availabilityIcon.textContent = icon;
        availabilityText.textContent = text;
        availabilityText.className = colorClass;
    }

    function hideAvailabilityStatus() {
        availabilityStatus.classList.add('hidden');
    }

    function resetCalculations() {
        durationSpan.textContent = '-- days';
        totalPriceSpan.textContent = '-- ₱';
    }

    function enableSubmitButtons() {
        submitButtons.forEach(button => {
            button.disabled = false;
            button.textContent = 'Reserve Now';
        });
    }

    function disableSubmitButtons() {
        submitButtons.forEach(button => {
            button.disabled = true;
            button.textContent = 'Select Valid Dates';
        });
    }

    // Set minimum date for end date based on start date
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = this.value;
        }
        updateDatesAndCalculations();
    });

    endDateInput.addEventListener('change', updateDatesAndCalculations);

    // Initialize
    disableSubmitButtons();
});
</script>
@endsection
