<h1>Checkout Test</h1>

<p>Plan: {{ $plan->name }}</p>

<form action="/plans/{{ $plan->id }}/checkout" method="POST">
    @csrf
    <button type="submit">
        Stripe Checkoutへ進む
    </button>
</form>
