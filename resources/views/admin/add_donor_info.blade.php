<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donor Information | LifeStream Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary-red: #dc2626;
      --dark-red: #b91c1c;
      --light-red: #fee2e2;
      --text-dark: #1f2937;
      --text-light: #6b7280;
    }

    body {
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      background-color: #f9fafb;
      color: var(--text-dark);
      padding-top: 20px;
      background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23fee2e2' fill-opacity='0.15' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
      background-color: var(--primary-red);
      color: white;
      font-weight: 600;
      padding: 15px 20px;
      border: none;
    }
    
    .card-body {
      padding: 25px;
    }
    
    .form-label {
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 8px;
    }
    
    .form-control, .form-select {
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 10px 15px;
      transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--primary-red);
      box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.15);
    }
    
    .btn-primary {
      background-color: var(--primary-red);
      border-color: var(--primary-red);
      padding: 10px 20px;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s;
    }
    
    .btn-primary:hover {
      background-color: var(--dark-red);
      border-color: var(--dark-red);
      transform: translateY(-2px);
    }
    
    .btn-outline-primary {
      color: var(--primary-red);
      border-color: var(--primary-red);
      padding: 10px 20px;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s;
    }
    
    .btn-outline-primary:hover {
      background-color: var(--light-red);
      color: var(--dark-red);
      border-color: var(--dark-red);
    }
    
    .alert {
      border-radius: 8px;
      padding: 15px 20px;
    }
    
    .alert-success {
      background-color: #dcfce7;
      border-color: #bbf7d0;
      color: #166534;
    }
    
    .alert-danger {
      background-color: #fee2e2;
      border-color: #fecaca;
      color: #b91c1c;
    }
    
    .header-icon {
      background-color: var(--light-red);
      color: var(--primary-red);
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 15px;
      font-size: 1.5rem;
    }
    
    .section-title {
      position: relative;
      padding-bottom: 10px;
      margin-bottom: 20px;
      color: var(--dark-red);
    }
    
    .section-title:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 3px;
      background-color: var(--primary-red);
      border-radius: 3px;
    }
    
    .form-check-input:checked {
      background-color: var(--primary-red);
      border-color: var(--primary-red);
    }
    
    .required-star {
      color: var(--primary-red);
      margin-left: 3px;
    }
    
    .form-section {
      background-color: #fff;
      border-radius: 10px;
      padding: 25px;
      margin-bottom: 25px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .system-header {
      text-align: center;
      margin-bottom: 30px;
      padding: 15px;
      border-bottom: 1px solid #e2e8f0;
    }
    
    .system-title {
      color: var(--primary-red);
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 10px;
    }
    
    .system-subtitle {
      color: var(--text-light);
      font-size: 1.1rem;
    }
    
    .footer {
      text-align: center;
      margin-top: 30px;
      padding: 20px;
      color: var(--text-light);
      font-size: 0.9rem;
    }
    
    .input-group-text {
      background-color: var(--light-red);
      border: 1px solid #e2e8f0;
      color: var(--primary-red);
    }
    
    .info-icon {
      color: var(--primary-red);
      margin-right: 8px;
    }
    
    .divider {
      height: 1px;
      background: linear-gradient(to right, transparent, #e2e8f0, transparent);
      margin: 30px 0;
    }
    
    .info-display {
      background-color: #f8f9fa;
      border: 1px solid #e9ecef;
      border-radius: 8px;
      padding: 12px 15px;
      margin-bottom: 15px;
    }
    
    .info-display-label {
      font-size: 0.85rem;
      color: var(--text-light);
      margin-bottom: 5px;
    }
    
    .info-display-value {
      font-size: 1rem;
      font-weight: 500;
      color: var(--text-dark);
    }
    
    .editable-section {
      background-color: #f8f9fa;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      border-left: 4px solid var(--primary-red);
    }
    
    .status-badge {
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
    }
    
    .status-active {
      background-color: #dcfce7;
      color: #16a34a;
    }
    
    .status-inactive {
      background-color: #fffbeb;
      color: #d97706;
    }
    
    @media (max-width: 768px) {
      .card-body {
        padding: 20px;
      }
      
      .form-section {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- System Header -->
    <div class="system-header mb-5">
      <h1 class="system-title">
        <i class="fas fa-tint"></i>
        LifeStream Blood Donation System
      </h1>
      <p class="system-subtitle">Admin Panel - Donor Management</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Please fix the following issues:</strong>
        <ul class="mt-2 mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="row">
      {{-- Left Column: Search Existing Donor --}}
      <div class="col-lg-5 mb-4">
        <form method="POST" action="{{ route('admin.donors.search') }}">
  @csrf
  
  <div class="mb-4">
    <div class="header-icon mx-auto">
      <i class="fas fa-user"></i>
    </div>
    <h5 class="text-center mb-4">Find Donor by Name or ID</h5>
    
    <div class="input-group mb-3">
      <span class="input-group-text">
        <i class="fas fa-search"></i>
      </span>
      <input
        type="text"
        name="query"
        id="query"
        class="form-control form-control-lg"
        value="{{ old('query') }}"
        placeholder="Enter donor name or ID"
        required
      >
    </div>
    
    <p class="text-muted small mb-4">
      <i class="fas fa-info-circle info-icon"></i>
      Search donors by their name or unique ID from donor records.
    </p>
    
    <button type="submit" class="btn btn-primary w-100 py-3">
      <i class="fas fa-search me-2"></i> Search Donor
    </button>
  </div>
</form>
        @php
    $donor = $donor ?? null;
@endphp
        <div class="card mt-4">
          <div class="card-header d-flex align-items-center">
            <i class="fas fa-lightbulb me-2"></i>
            Quick Tips
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex">
                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                <div>
                  <strong>Personal Info:</strong> Display-only for existing donors
                </div>
              </li>
              <li class="list-group-item d-flex">
                <i class="fas fa-edit text-primary me-3 mt-1"></i>
                <div>
                  <strong>Donation Info:</strong> Editable fields for recent donations
                </div>
              </li>
              <li class="list-group-item d-flex">
                <i class="fas fa-hospital text-info me-3 mt-1"></i>
                <div>
                  <strong>Donation Center:</strong> Track where donations occurred
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      {{-- Right Column: Add/Edit Donor Form --}}
      <div class="col-lg-7 mb-4">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <i class="fas fa-user-edit me-2"></i>
            @if(isset($donor) && $donor)
               {{ $donor->first_name }} {{ $donor->last_name }}
            @else
              Donor Information
            @endif
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('admin.donors.save_info') }}">
              @csrf

      <h5 class="section-title">Personal Information</h5>
@php
    $query = $query ?? '';
@endphp
@if(isset($userDetails) && $userDetails->count() > 0)
    @foreach($userDetails as $detail)
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" class="form-control" value="{{ $detail->first_name }}" readonly>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" class="form-control" value="{{ $detail->last_name }}" readonly>
        </div>

        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" class="form-control" value="{{ $detail->phone_number }}" readonly>
        </div>

        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" class="form-control" value="{{ $detail->date_of_birth }}" readonly>
        </div>

        <div class="mb-3">
            <label>Blood Type</label>
            <input type="text" class="form-control" value="{{ $detail->blood_type }}" readonly>
        </div>

        <div class="mb-3">
            <label>Weight (lbs)</label>
            <input type="number" class="form-control" value="{{ $detail->weight_lbs }}" readonly>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea class="form-control" readonly>{{ $detail->address }}</textarea>
        </div>
        <hr>
    @endforeach
@else
    <p>No donor found matching "{{ $query }}"</p>
@endif


              
              <div class="divider"></div>
              
              <div class="editable-section">
                <h5 class="section-title">Donation Information</h5>
                
                <div class="row mb-4">
                  <div class="col-md-6 mb-3">
                    <label for="last_donation_date" class="form-label">
                      Last Donation Date
                    </label>
                    <div class="input-group">
                      <span class="input-group-text">
                        <i class="fas fa-calendar-check"></i>
                      </span>
                      <input
                        type="date"
                        name="last_donation_date"
                        id="last_donation_date"
                        class="form-control"
                        value="{{ old('last_donation_date', optional($donor)->last_donation_date ? $donor->last_donation_date->format('Y-m-d') : '') }}"
                      >
                    </div>
                  </div>
                  
                  <div class="col-md-6 mb-3">
                    <label for="next_eligible_donation" class="form-label">
                      Next Eligible Donation
                    </label>
                    <div class="input-group">
                      <span class="input-group-text">
                        <i class="fas fa-calendar-day"></i>
                      </span>
                      <input
                        type="date"
                        name="next_eligible_donation"
                        id="next_eligible_donation"
                        class="form-control"
                        value="{{ old('next_eligible_donation', optional($donor)->next_eligible_donation ? $donor->next_eligible_donation->format('Y-m-d') : '') }}"
                      >
                    </div>
                  </div>
                  
                  <div class="col-md-4 mb-3">
                    <label for="volume_ml" class="form-label">
                      Volume Donated (ml)
                    </label>
                    <div class="input-group">
                      <span class="input-group-text">
                        <i class="fas fa-flask"></i>
                      </span>
                      <input
                        type="number"
                        name="volume_ml"
                        id="volume_ml"
                        class="form-control"
                        value="{{ old('volume_ml', optional($donor)->volume_ml) }}"
                        min="0"
                        step="50"
                      >
                    </div>
                  </div>
                  
                  <div class="col-md-8 mb-3">
                    <label for="donation_center" class="form-label">
                      Donation Center
                    </label>
                    <div class="input-group">
                      <span class="input-group-text">
                        <i class="fas fa-hospital"></i>
                      </span>
                      <select name="donation_center" id="donation_center" class="form-select">
                        <option value="">Select Center</option>
                        <option value="KCMC Hospital" {{ old('donation_center', optional($donor)->donation_center) == 'main' ? 'selected' : '' }}>KCMC Hospital</option>
                        <option value="Arusha Blood Center" {{ old('donation_center', optional($donor)->donation_center) == 'north' ? 'selected' : '' }}>Arusha Blood Center</option>
                        <option value="Manyara Blood Center" {{ old('donation_center', optional($donor)->donation_center) == 'south' ? 'selected' : '' }}>Manyara Blood Center</option>
                        <option value="Tanga Blood Center" {{ old('donation_center', optional($donor)->donation_center) == 'west' ? 'selected' : '' }}>Tanga Blood Center</option>
                        
                      </select>
                    </div>
                  </div>
                  
                  <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">
                      <i class="fas fa-sticky-note me-1"></i> Notes / Comments
                    </label>
                    <textarea
                      name="notes"
                      id="notes"
                      class="form-control"
                      rows="3"
                    >{{ old('notes', optional($donor)->notes) }}</textarea>
                  </div>
                </div>
              </div>
              
              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-lg py-3">
                  <i class="fas fa-save me-2"></i>
                
                    Update Donation Information 
                 
                </button>
                
                <button type="reset" class="btn btn-outline-primary mt-2">
                  <i class="fas fa-redo me-2"></i>
                  Reset Form
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <div class="footer">
      <p class="mb-1">LifeStream Blood Donation System &copy; {{ date('Y') }}</p>
      <p class="small text-muted">Saving lives through blood donation</p>
    </div>
  </div>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Add slight animation to form elements on focus
    document.querySelectorAll('.form-control, .form-select').forEach(el => {
      el.addEventListener('focus', function() {
        this.parentElement.classList.add('shadow-sm');
      });
      
      el.addEventListener('blur', function() {
        this.parentElement.classList.remove('shadow-sm');
      });
    });
    
    // Calculate next eligible date based on last donation
    document.getElementById('last_donation_date').addEventListener('change', function() {
      if (this.value) {
        const lastDonation = new Date(this.value);
        const nextEligible = new Date(lastDonation);
        nextEligible.setDate(nextEligible.getDate() + 56); // 8 weeks later
        
        const formattedDate = nextEligible.toISOString().split('T')[0];
        document.getElementById('next_eligible_donation').value = formattedDate;
      }
    });
    
    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
  </script>
</body>
</html>