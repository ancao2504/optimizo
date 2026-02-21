@extends('layouts.app')

@section('title', __tool('scientific-calculator', 'meta.title'))
@section('meta_description', __tool('scientific-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="scientific-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <!-- Display -->
            <div class="mb-4">
                <div id="history" class="text-right text-sm text-gray-400 h-6 px-2 font-mono"></div>
                <input type="text" id="display" value="0" readonly
                    class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl bg-gray-50 text-4xl font-mono text-right focus:outline-none">
            </div>

            <div class="flex justify-between items-center mb-4">
                <span id="mode-indicator"
                    class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-sm font-bold">DEG</span>
                <span id="memory-indicator"
                    class="px-3 py-1 bg-gray-100 text-gray-500 rounded-lg text-sm font-bold hidden">M</span>
            </div>

            <!-- Calculator Buttons -->
            <div class="grid grid-cols-5 gap-2">
                <!-- Row 1: Memory + Clear -->
                <button onclick="memClear()"
                    class="calc-btn bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm">MC</button>
                <button onclick="memRecall()"
                    class="calc-btn bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm">MR</button>
                <button onclick="memAdd()" class="calc-btn bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm">M+</button>
                <button onclick="clearEntry()" class="calc-btn bg-red-100 text-red-700 hover:bg-red-200">CE</button>
                <button onclick="clearAll()" class="calc-btn bg-red-100 text-red-700 hover:bg-red-200">C</button>

                <!-- Row 2: Scientific -->
                <button onclick="calcFunc('sin')"
                    class="calc-btn bg-purple-100 text-purple-700 hover:bg-purple-200 text-sm">sin</button>
                <button onclick="calcFunc('cos')"
                    class="calc-btn bg-purple-100 text-purple-700 hover:bg-purple-200 text-sm">cos</button>
                <button onclick="calcFunc('tan')"
                    class="calc-btn bg-purple-100 text-purple-700 hover:bg-purple-200 text-sm">tan</button>
                <button onclick="appendOp('^')"
                    class="calc-btn bg-purple-100 text-purple-700 hover:bg-purple-200 text-sm">xⁿ</button>
                <button onclick="calcFunc('sqrt')"
                    class="calc-btn bg-purple-100 text-purple-700 hover:bg-purple-200 text-sm">√</button>

                <!-- Row 3: More Scientific -->
                <button onclick="calcFunc('log')"
                    class="calc-btn bg-purple-100 text-purple-700 hover:bg-purple-200 text-sm">log</button>
                <button onclick="calcFunc('ln')"
                    class="calc-btn bg-purple-100 text-purple-700 hover:bg-purple-200 text-sm">ln</button>
                <button onclick="insertConst('pi')"
                    class="calc-btn bg-purple-100 text-purple-700 hover:bg-purple-200 text-sm">π</button>
                <button onclick="insertConst('e')"
                    class="calc-btn bg-purple-100 text-purple-700 hover:bg-purple-200 text-sm">e</button>
                <button onclick="calcFunc('fact')"
                    class="calc-btn bg-purple-100 text-purple-700 hover:bg-purple-200 text-sm">n!</button>

                <!-- Row 4-7: Standard Calculator -->
                <button onclick="appendNum('7')"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">7</button>
                <button onclick="appendNum('8')"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">8</button>
                <button onclick="appendNum('9')"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">9</button>
                <button onclick="appendOp('/')"
                    class="calc-btn bg-orange-100 text-orange-700 hover:bg-orange-200 text-lg">÷</button>
                <button onclick="backspace()"
                    class="calc-btn bg-gray-100 text-gray-700 hover:bg-gray-200 text-lg">⌫</button>

                <button onclick="appendNum('4')"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">4</button>
                <button onclick="appendNum('5')"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">5</button>
                <button onclick="appendNum('6')"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">6</button>
                <button onclick="appendOp('*')"
                    class="calc-btn bg-orange-100 text-orange-700 hover:bg-orange-200 text-lg">×</button>
                <button onclick="appendOp('%')"
                    class="calc-btn bg-orange-100 text-orange-700 hover:bg-orange-200 text-lg">%</button>

                <button onclick="appendNum('1')"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">1</button>
                <button onclick="appendNum('2')"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">2</button>
                <button onclick="appendNum('3')"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">3</button>
                <button onclick="appendOp('-')"
                    class="calc-btn bg-orange-100 text-orange-700 hover:bg-orange-200 text-lg">−</button>
                <button onclick="toggleDegRad()"
                    class="calc-btn bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs">DEG/RAD</button>

                <button onclick="toggleSign()"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">±</button>
                <button onclick="appendNum('0')"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">0</button>
                <button onclick="appendNum('.')"
                    class="calc-btn bg-white border border-gray-200 hover:bg-gray-50 text-lg">.</button>
                <button onclick="appendOp('+')"
                    class="calc-btn bg-orange-100 text-orange-700 hover:bg-orange-200 text-lg">+</button>
                <button onclick="calculate()"
                    class="calc-btn bg-purple-600 text-white hover:bg-purple-700 text-lg font-bold">=</button>
            </div>
        </div>

        @php $content = __tool('scientific-calculator', 'content'); @endphp
        @if(is_array($content))
            <div
                class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                <h2 class="text-3xl font-black text-gray-900 mb-3 text-center">{{ $content['what_title'] ?? '' }}</h2>
                <p class="text-gray-600 text-center mx-auto max-w-xl mb-8">{{ $content['what_text'] ?? '' }}</p>

                @if(!empty($content['features']))
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $content['features_title'] ?? '' }}</h3>
                    <ul class="grid md:grid-cols-2 gap-3">
                        @foreach($content['features'] as $feat)
                            <li class="flex items-start gap-2 text-gray-600">
                                <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $feat }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif
    </div>

    <style>
        .calc-btn {
            @apply rounded-xl py-3 font-semibold transition-all active:scale-95;
        }
    </style>

    @push('scripts')
        <script>
            let currentInput = '0', previousInput = '', operation = '', memory = 0, degMode = true, newInput = true;

            function updateDisplay(val) { document.getElementById('display').value = val || currentInput; }
            function updateHistory(val) { document.getElementById('history').innerText = val || ''; }

            function appendNum(n) {
                if (newInput) { currentInput = n === '.' ? '0.' : n; newInput = false; }
                else {
                    if (n === '.' && currentInput.includes('.')) return;
                    currentInput = currentInput === '0' && n !== '.' ? n : currentInput + n;
                }
                updateDisplay();
            }

            function appendOp(op) {
                if (previousInput && !newInput) calculate();
                previousInput = currentInput;
                operation = op;
                newInput = true;
                updateHistory(previousInput + ' ' + (op === '*' ? '×' : op === '/' ? '÷' : op));
            }

            function calculate() {
                if (!previousInput || newInput) return;
                const a = parseFloat(previousInput), b = parseFloat(currentInput);
                let result;
                switch (operation) {
                    case '+': result = a + b; break;
                    case '-': result = a - b; break;
                    case '*': result = a * b; break;
                    case '/': result = b !== 0 ? a / b : "{{ __tool('scientific-calculator', 'js.error_division') }}"; break;
                    case '^': result = Math.pow(a, b); break;
                    case '%': result = a % b; break;
                    default: return;
                }
                updateHistory(previousInput + ' ' + operation + ' ' + currentInput + ' =');
                currentInput = String(typeof result === 'number' ? parseFloat(result.toPrecision(12)) : result);
                previousInput = ''; operation = ''; newInput = true;
                updateDisplay();
            }

            function calcFunc(fn) {
                const v = parseFloat(currentInput);
                let result;
                const toRad = degMode ? Math.PI / 180 : 1;
                switch (fn) {
                    case 'sin': result = Math.sin(v * toRad); break;
                    case 'cos': result = Math.cos(v * toRad); break;
                    case 'tan': result = Math.tan(v * toRad); break;
                    case 'log': result = v > 0 ? Math.log10(v) : NaN; break;
                    case 'ln': result = v > 0 ? Math.log(v) : NaN; break;
                    case 'sqrt': result = v >= 0 ? Math.sqrt(v) : NaN; break;
                    case 'fact': result = v >= 0 && v === Math.floor(v) ? factorial(v) : NaN; break;
                }
                if (isNaN(result)) { updateDisplay("{{ __tool('scientific-calculator', 'js.error_invalid') }}"); return; }
                currentInput = String(parseFloat(result.toPrecision(12))); newInput = true; updateDisplay();
            }

            function factorial(n) { if (n > 170) return Infinity; let r = 1; for (let i = 2; i <= n; i++) r *= i; return r; }

            function insertConst(c) { currentInput = c === 'pi' ? String(Math.PI) : String(Math.E); newInput = true; updateDisplay(); }
            function toggleSign() { currentInput = String(-parseFloat(currentInput)); updateDisplay(); }
            function toggleDegRad() { degMode = !degMode; document.getElementById('mode-indicator').innerText = degMode ? 'DEG' : 'RAD'; }
            function clearAll() { currentInput = '0'; previousInput = ''; operation = ''; newInput = true; updateDisplay(); updateHistory(); }
            function clearEntry() { currentInput = '0'; newInput = true; updateDisplay(); }
            function backspace() { currentInput = currentInput.length > 1 ? currentInput.slice(0, -1) : '0'; updateDisplay(); }

            function memClear() { memory = 0; document.getElementById('memory-indicator').classList.add('hidden'); }
            function memRecall() { currentInput = String(memory); newInput = true; updateDisplay(); }
            function memAdd() { memory += parseFloat(currentInput); document.getElementById('memory-indicator').classList.remove('hidden'); }

            document.addEventListener('keydown', e => {
                if (e.key >= '0' && e.key <= '9') appendNum(e.key);
                else if (e.key === '.') appendNum('.');
                else if (['+', '-', '*', '/'].includes(e.key)) appendOp(e.key);
                else if (e.key === 'Enter' || e.key === '=') { e.preventDefault(); calculate(); }
                else if (e.key === 'Escape') clearAll();
                else if (e.key === 'Backspace') backspace();
            });
        </script>
    @endpush
@endsection