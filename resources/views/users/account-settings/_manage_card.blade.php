<div class="bg-white px-6 py-6 mt-12 rounded-md shadow-md text-gray-700 w-full">
    <div class="flex flex-wrap">
        <div class="w-full md:w-1/3">
            <h2 class="text-xl">Manage Card</h2>
            <p class="mt-4 text-sm text-gray-600 tracking-wider pr-6">Update your card here. Whenever you add new card, you will have to use that card as Default Card.</p>
        </div>

        <div class="mt-6 md:mt-0 w-full md:w-2/3">
        <h4 class="text-xl">Default Card</h4>
            @foreach($cards as $key => $card)
                <input type="radio" name="default_card" class="default_card" value="{{ $card['card_id'] }}" onchange="defaultCard('{{ $card['card_id'] }}')" {{ $default_card === $card['card_id'] ? 'checked' : ''; }}>
                {{ $card['card_last4']}}  <br/>
                &nbsp &nbsp Expires {{ $card['card_exp_month'] }} / {{ $card['card_exp_year'] }} <br /><br/>
            @endforeach
        </div>
    </div>
</div>
