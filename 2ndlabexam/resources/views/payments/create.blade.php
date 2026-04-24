<x-app-layout>
    <x-slot name="pageTitle">Process Payment</x-slot>

    <div class="page-header">
        <div>
            <h1>Process Payment</h1>
            <p>Complete the steps below to record a payment.</p>
        </div>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">← Back to Payments</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="max-width:760px;">
            @foreach($errors->all() as $error){{ $error }}<br>@endforeach
        </div>
    @endif

    <!-- Step Indicator -->
    <div style="max-width:760px; margin-bottom:32px;">
        <div style="display:flex; align-items:center; gap:0;">

            <div class="step-indicator" id="step-ind-1" style="display:flex; align-items:center; gap:10px; flex:1;">
                <div class="step-circle active" id="step-circle-1">1</div>
                <div>
                    <div class="step-label active" id="step-label-1">Select Order</div>
                    <div style="font-size:11px; color:var(--text-muted);">Choose pending order</div>
                </div>
            </div>

            <div style="flex:1; height:2px; background:var(--cream-dark); position:relative; margin:0 8px; top:-8px;">
                <div id="line-1-2" style="height:100%; width:0%; background:var(--tan); transition:width 0.4s ease;"></div>
            </div>

            <div class="step-indicator" id="step-ind-2" style="display:flex; align-items:center; gap:10px; flex:1;">
                <div class="step-circle" id="step-circle-2">2</div>
                <div>
                    <div class="step-label" id="step-label-2">Confirm Details</div>
                    <div style="font-size:11px; color:var(--text-muted);">Review order summary</div>
                </div>
            </div>

            <div style="flex:1; height:2px; background:var(--cream-dark); position:relative; margin:0 8px; top:-8px;">
                <div id="line-2-3" style="height:100%; width:0%; background:var(--tan); transition:width 0.4s ease;"></div>
            </div>

            <div class="step-indicator" id="step-ind-3" style="display:flex; align-items:center; gap:10px; flex:1;">
                <div class="step-circle" id="step-circle-3">3</div>
                <div>
                    <div class="step-label" id="step-label-3">Payment Method</div>
                    <div style="font-size:11px; color:var(--text-muted);">Choose & submit</div>
                </div>
            </div>

        </div>
    </div>

    <!-- Wizard Card -->
    <div class="card" style="max-width:760px;">
        <div class="card-body">
            <form action="{{ route('payments.store') }}" method="POST" id="paymentForm">
                @csrf

                <!-- Hidden fields populated by JS -->
                <input type="hidden" name="order_id" id="hidden_order_id">
                <input type="hidden" name="payment_method" id="hidden_payment_method">

                <!-- ── STEP 1: Select Order ── -->
                <div id="step1">
                    <h3 style="font-family:'Playfair Display',serif; font-size:18px; color:var(--brown-dark); margin-bottom:6px;">Select an Order</h3>
                    <p style="font-size:13px; color:var(--text-muted); margin-bottom:24px;">Only pending orders without an existing payment are shown.</p>

                    <div style="display:flex; flex-direction:column; gap:10px;" id="order-list">
                        @forelse($orders as $order)
                        <label class="order-option" data-id="{{ $order->id }}"
                            data-rice="{{ $order->rice->name }}"
                            data-qty="{{ $order->quantity }}"
                            data-total="{{ $order->total_price }}"
                            data-customer="{{ $order->user->name }}"
                            style="display:flex; align-items:center; justify-content:space-between; padding:16px 18px; border:1.5px solid var(--cream-dark); border-radius:10px; cursor:pointer; transition:all 0.18s ease;">
                            <div style="display:flex; align-items:center; gap:14px;">
                                <input type="radio" name="_order_select" value="{{ $order->id }}" style="accent-color:var(--brown); width:18px; height:18px;">
                                <div>
                                    <div style="font-weight:600; font-size:14px; color:var(--brown-dark);">Order #{{ $order->id }} — {{ $order->rice->name }}</div>
                                    <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">Customer: {{ $order->user->name }} · {{ $order->quantity }} kg</div>
                                </div>
                            </div>
                            <div style="font-family:'Playfair Display',serif; font-size:18px; font-weight:600; color:var(--brown);">₱{{ number_format($order->total_price, 2) }}</div>
                        </label>
                        @empty
                        <div style="text-align:center; padding:40px; color:var(--text-muted);">
                            No pending orders available. <a href="{{ route('orders.create') }}" style="color:var(--brown); font-weight:500;">Create an order first →</a>
                        </div>
                        @endforelse
                    </div>

                    <div style="margin-top:24px; display:flex; justify-content:flex-end;">
                        <button type="button" class="btn btn-primary" id="btn-step1-next" onclick="goToStep(2)" disabled>
                            Continue →
                        </button>
                    </div>
                </div>

                <!-- ── STEP 2: Confirm Details ── -->
                <div id="step2" style="display:none;">
                    <h3 style="font-family:'Playfair Display',serif; font-size:18px; color:var(--brown-dark); margin-bottom:6px;">Confirm Order Details</h3>
                    <p style="font-size:13px; color:var(--text-muted); margin-bottom:24px;">Review the order before proceeding to payment.</p>

                    <div style="background:var(--cream); border-radius:10px; padding:24px; border:1px solid var(--cream-dark); display:flex; flex-direction:column; gap:16px;">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div>
                                <div style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--text-muted); margin-bottom:4px;">Order ID</div>
                                <div style="font-weight:600; color:var(--brown-dark);" id="confirm-order-id">—</div>
                            </div>
                            <div>
                                <div style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--text-muted); margin-bottom:4px;">Customer</div>
                                <div style="font-weight:500;" id="confirm-customer">—</div>
                            </div>
                            <div>
                                <div style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--text-muted); margin-bottom:4px;">Rice Product</div>
                                <div style="font-weight:500;" id="confirm-rice">—</div>
                            </div>
                            <div>
                                <div style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--text-muted); margin-bottom:4px;">Quantity</div>
                                <div style="font-weight:500;" id="confirm-qty">—</div>
                            </div>
                        </div>
                        <div style="height:1px; background:var(--cream-dark);"></div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <div style="font-size:15px; font-weight:600; color:var(--brown-dark);">Amount to Collect</div>
                            <div style="font-family:'Playfair Display',serif; font-size:28px; font-weight:600; color:var(--brown);" id="confirm-total">₱0.00</div>
                        </div>
                    </div>

                    <div style="margin-top:24px; display:flex; justify-content:space-between;">
                        <button type="button" class="btn btn-secondary" onclick="goToStep(1)">← Back</button>
                        <button type="button" class="btn btn-primary" onclick="goToStep(3)">Confirm & Continue →</button>
                    </div>
                </div>

                <!-- ── STEP 3: Payment Method ── -->
                <div id="step3" style="display:none;">
                    <h3 style="font-family:'Playfair Display',serif; font-size:18px; color:var(--brown-dark); margin-bottom:6px;">Choose Payment Method</h3>
                    <p style="font-size:13px; color:var(--text-muted); margin-bottom:24px;">Select how the customer will pay.</p>

                    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:14px; margin-bottom:28px;">

                        <label class="method-option" data-method="cash"
                            style="display:flex; flex-direction:column; align-items:center; gap:10px; padding:22px 16px; border:1.5px solid var(--cream-dark); border-radius:12px; cursor:pointer; transition:all 0.18s ease; text-align:center;">
                            <input type="radio" name="_method_select" value="cash" style="display:none;">
                            <span style="font-size:32px;">💵</span>
                            <span style="font-weight:600; font-size:14px; color:var(--brown-dark);">Cash</span>
                            <span style="font-size:12px; color:var(--text-muted);">Pay in person</span>
                        </label>

                        <label class="method-option" data-method="card"
                            style="display:flex; flex-direction:column; align-items:center; gap:10px; padding:22px 16px; border:1.5px solid var(--cream-dark); border-radius:12px; cursor:pointer; transition:all 0.18s ease; text-align:center;">
                            <input type="radio" name="_method_select" value="card" style="display:none;">
                            <span style="font-size:32px;">💳</span>
                            <span style="font-weight:600; font-size:14px; color:var(--brown-dark);">Card</span>
                            <span style="font-size:12px; color:var(--text-muted);">Debit or credit</span>
                        </label>

                        <label class="method-option" data-method="online"
                            style="display:flex; flex-direction:column; align-items:center; gap:10px; padding:22px 16px; border:1.5px solid var(--cream-dark); border-radius:12px; cursor:pointer; transition:all 0.18s ease; text-align:center;">
                            <input type="radio" name="_method_select" value="online" style="display:none;">
                            <span style="font-size:32px;">📱</span>
                            <span style="font-weight:600; font-size:14px; color:var(--brown-dark);">Online</span>
                            <span style="font-size:12px; color:var(--text-muted);">GCash / transfer</span>
                        </label>

                    </div>

                    <!-- Final summary strip -->
                    <div style="background:var(--cream); border-radius:10px; padding:16px 20px; border:1px solid var(--cream-dark); display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                        <div style="font-size:13px; color:var(--text-muted);">Collecting for <strong id="final-order-label" style="color:var(--brown-dark);">—</strong></div>
                        <div style="font-family:'Playfair Display',serif; font-size:22px; font-weight:600; color:var(--brown);" id="final-total">₱0.00</div>
                    </div>

                    <div style="display:flex; justify-content:space-between;">
                        <button type="button" class="btn btn-secondary" onclick="goToStep(2)">← Back</button>
                        <button type="submit" class="btn btn-primary" id="btn-submit" disabled>
                            ✓ Process Payment
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <style>
        .step-circle {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--cream-dark);
            color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 600;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }
        .step-circle.active { background: var(--brown); color: white; }
        .step-circle.done   { background: var(--tan);   color: white; }
        .step-label { font-size: 13px; font-weight: 500; color: var(--text-muted); transition: color 0.3s; }
        .step-label.active { color: var(--brown-dark); font-weight: 600; }

        .order-option:hover  { border-color: var(--tan); background: #fdf9f4; }
        .order-option.selected { border-color: var(--brown); background: #fdf6ee; box-shadow: 0 0 0 3px rgba(122,92,56,0.10); }

        .method-option:hover   { border-color: var(--tan); background: #fdf9f4; }
        .method-option.selected { border-color: var(--brown); background: #fdf6ee; box-shadow: 0 0 0 3px rgba(122,92,56,0.10); }
    </style>

    <script>
        let currentStep = 1;
        let selectedOrder = null;
        let selectedMethod = null;

        // Order selection
        document.querySelectorAll('.order-option').forEach(opt => {
            opt.addEventListener('click', function () {
                document.querySelectorAll('.order-option').forEach(o => o.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type=radio]').checked = true;
                selectedOrder = {
                    id: this.dataset.id,
                    rice: this.dataset.rice,
                    qty: this.dataset.qty,
                    total: parseFloat(this.dataset.total),
                    customer: this.dataset.customer
                };
                document.getElementById('btn-step1-next').disabled = false;
            });
        });

        // Method selection
        document.querySelectorAll('.method-option').forEach(opt => {
            opt.addEventListener('click', function () {
                document.querySelectorAll('.method-option').forEach(o => o.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type=radio]').checked = true;
                selectedMethod = this.dataset.method;
                document.getElementById('btn-submit').disabled = false;
            });
        });

        function goToStep(n) {
            // Populate step 2 confirm details
            if (n === 2 && selectedOrder) {
                document.getElementById('confirm-order-id').textContent = '#' + selectedOrder.id;
                document.getElementById('confirm-customer').textContent = selectedOrder.customer;
                document.getElementById('confirm-rice').textContent = selectedOrder.rice;
                document.getElementById('confirm-qty').textContent = selectedOrder.qty + ' kg';
                document.getElementById('confirm-total').textContent = '₱' + selectedOrder.total.toFixed(2);
            }
            // Populate step 3 final strip
            if (n === 3 && selectedOrder) {
                document.getElementById('final-order-label').textContent = 'Order #' + selectedOrder.id;
                document.getElementById('final-total').textContent = '₱' + selectedOrder.total.toFixed(2);
                document.getElementById('hidden_order_id').value = selectedOrder.id;
            }

            // Show/hide steps
            for (let i = 1; i <= 3; i++) {
                document.getElementById('step' + i).style.display = (i === n) ? 'block' : 'none';
            }

            // Update step indicators
            for (let i = 1; i <= 3; i++) {
                const circle = document.getElementById('step-circle-' + i);
                const label  = document.getElementById('step-label-' + i);
                circle.classList.remove('active', 'done');
                label.classList.remove('active');
                if (i < n)  { circle.classList.add('done');   }
                if (i === n){ circle.classList.add('active'); label.classList.add('active'); }
            }

            // Progress lines
            document.getElementById('line-1-2').style.width = (n >= 2) ? '100%' : '0%';
            document.getElementById('line-2-3').style.width = (n >= 3) ? '100%' : '0%';

            currentStep = n;
        }

        // On submit, set hidden payment_method
        document.getElementById('paymentForm').addEventListener('submit', function () {
            document.getElementById('hidden_payment_method').value = selectedMethod;
        });
    </script>

</x-app-layout>