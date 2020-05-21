<!-- Modal -->
<div class="modal fade" id="cancel-booking-modal" tabindex="-1" role="dialog" aria-labelledby="vehicle-stat-modal-label" aria-hidden="true">
    <form  id="form-cancel-booking" method="POST" action="{{ route('cancelBooking') }}">
        @method('POST')
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="vehicle-stat-modal-label">Cancel Booking?</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <input type="hidden" id="c-booking-id" name="booking_id">
                        <div class="col-md-12">
                            <table class="table table-sm table-borderless table-striped">
                                <tr>
                                    <td class="font-weight-bold">Booking No:</td>
                                    <td><span id="c-booking-no"></span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Schedule:</td>
                                    <td><span id="c-schedule"></span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Destination:</td>
                                    <td><span id="c-destination"></span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="destination">Enter reason why you want to cancel this booking?</label>
                                <textarea id class="form-control resize-none  @error('cancellation_reason') is-invalid @enderror" id="cancellation-reason" name="cancellation_reason" rows="3" maxlength="300">{{ old('cancellation_reason') }}</textarea>
                                @error('cancellation_reason')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-block">
                    <div class="row">
                        <div class="col-md-4 offset-md-2">
                            <button btn="btn-cancel-booking" type="button" class="btn btn-primary btn-block" data-dismiss="modal">No</button>
                        </div>
                        <div class="col-md-4">
                            <button id="btn-submit-booking" type="button" class="btn btn-danger btn-block" onclick="return confirmCancelBooking()">Yes, cancel it!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
