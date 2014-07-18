<?php

namespace Arh\Stripe;

trait BillableTrait
{
    public function addInvoiceItem($amount, $description, $currency = 'eur')
    {
        \Stripe::setApiKey(\Config::get('stripe.secret-key'));
        \Stripe_InvoiceItem::create(
            array(
                'customer' => $this->stripe_id,
                'amount' => $amount,
                'currency' => $currency,
                'description' => $description
            )
        );
    }

    public function getCustomer()
    {
        \Stripe::setApiKey(\Config::get('stripe.secret-key'));
        return \Stripe_Customer::retrieve($this->stripe_id);
    }

    public function getCard()
    {
        $c = $this->getCustomer();
        if (isset($c->cards->data[0]))
        {
            return $c->cards->data[0];
        }
        return null;
    }
}