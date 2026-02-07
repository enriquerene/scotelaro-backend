<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Modality;
use App\Models\GymClass;
use App\Models\PricingTier;

class OnboardingWizard extends Component
{
    public $step = 1;
    public $selectedModalities = [];
    public $selectedClasses = [];
    public $pricingTier = null;
    public $total = 0;
    public $paymentMethod = 'credit_card';
    public $cardNumber = '';
    public $cardExpiry = '';
    public $cardCvc = '';
    public $isProcessing = false;

    protected $listeners = ['proceed', 'back'];

    public function mount()
    {
        // If user already has active subscription, redirect
        $user = auth()->user();
        if ($user->subscriptions()->where('status', 'active')->where('ends_at', '>', now())->exists()) {
            return redirect()->route('app.home');
        }
    }

    public function render()
    {
        $modalities = Modality::with('classes')->get();
        $classes = GymClass::whereIn('modality_id', $this->selectedModalities)->get();
        $pricingTiers = PricingTier::all();

        return view('livewire.onboarding-wizard', compact('modalities', 'classes', 'pricingTiers'));
    }

    public function updatedSelectedModalities()
    {
        $this->selectedClasses = [];
        $this->calculatePrice();
    }

    public function updatedSelectedClasses()
    {
        $this->calculatePrice();
    }

    public function calculatePrice()
    {
        $classCount = count($this->selectedClasses);
        $this->pricingTier = PricingTier::where('class_count', $classCount)->first();
        $this->total = $this->pricingTier ? $this->pricingTier->price : 0;
    }

    public function proceed()
    {
        // Validate current step before proceeding
        if (!$this->validateStep()) {
            return;
        }

        if ($this->step < 4) {
            $this->step++;
        } else {
            // Step 4 is payment, process it
            $this->processPayment();
        }
    }

    private function validateStep(): bool
    {
        if ($this->step === 1 && empty($this->selectedModalities)) {
            $this->addError('selectedModalities', 'Please select at least one modality.');
            return false;
        }

        if ($this->step === 2 && empty($this->selectedClasses)) {
            $this->addError('selectedClasses', 'Please select at least one class.');
            return false;
        }

        if ($this->step === 3 && !$this->pricingTier) {
            $this->addError('pricingTier', 'Please select a pricing tier.');
            return false;
        }

        if ($this->step === 4) {
            // Simple payment validation
            if ($this->paymentMethod === 'credit_card') {
                if (strlen($this->cardNumber) < 16) {
                    $this->addError('cardNumber', 'Please enter a valid card number.');
                    return false;
                }
                if (empty($this->cardExpiry)) {
                    $this->addError('cardExpiry', 'Please enter card expiry date.');
                    return false;
                }
                if (strlen($this->cardCvc) < 3) {
                    $this->addError('cardCvc', 'Please enter card CVC.');
                    return false;
                }
            }
        }

        return true;
    }

    public function processPayment()
    {
        $this->isProcessing = true;
        
        // Mock payment processing delay
        sleep(2);
        
        // Simulate successful payment
        $paymentSuccess = true; // Mock always succeeds
        
        if ($paymentSuccess) {
            $this->createSubscription();
        } else {
            $this->addError('payment', 'Payment failed. Please try again.');
            $this->isProcessing = false;
        }
    }

    public function back()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    private function createSubscription()
    {
        $user = auth()->user();
        
        // Create subscription
        $subscription = $user->subscriptions()->create([
            'pricing_tier_id' => $this->pricingTier->id,
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
            'payment_method' => $this->paymentMethod,
            'amount' => $this->total,
        ]);

        // Create enrollments for selected classes
        foreach ($this->selectedClasses as $classId) {
            $user->enrollments()->create([
                'gym_class_id' => $classId,
                'subscription_id' => $subscription->id,
            ]);
        }

        $this->isProcessing = false;
        
        // Redirect to app with success message
        return redirect()->route('app.home')->with('success', 'Subscription created successfully! Welcome to Scotelaro!');
    }
}
