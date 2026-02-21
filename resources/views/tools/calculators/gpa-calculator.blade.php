@extends('layouts.app')

@section('title', __tool('gpa-calculator', 'meta.title'))
@section('meta_description', __tool('gpa-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="gpa-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <div id="gpa-courses">
                <div class="gpa-row grid grid-cols-12 gap-3 mb-3 items-end">
                    <div class="col-span-5">
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-1">{{ __tool('gpa-calculator', 'editor.label_course') }}</label>
                        <input type="text" placeholder="{{ __tool('gpa-calculator', 'editor.placeholder_course') }}"
                            class="gpa-name w-full px-3 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm">
                    </div>
                    <div class="col-span-4">
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-1">{{ __tool('gpa-calculator', 'editor.label_grade') }}</label>
                        <select
                            class="gpa-grade w-full px-3 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm">
                            <option value="4.0">A / A+</option>
                            <option value="3.7">A-</option>
                            <option value="3.3">B+</option>
                            <option value="3.0">B</option>
                            <option value="2.7">B-</option>
                            <option value="2.3">C+</option>
                            <option value="2.0">C</option>
                            <option value="1.7">C-</option>
                            <option value="1.3">D+</option>
                            <option value="1.0">D</option>
                            <option value="0.0">F</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-1">{{ __tool('gpa-calculator', 'editor.label_credits') }}</label>
                        <input type="number" value="3" min="0.5" max="12" step="0.5"
                            class="gpa-credits w-full px-3 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm">
                    </div>
                    <div class="col-span-1 flex items-center justify-center pb-1">
                        <button onclick="this.closest('.gpa-row').remove()"
                            class="text-red-400 hover:text-red-600 transition-colors"
                            title="{{ __tool('gpa-calculator', 'editor.btn_remove') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 mb-6">
                <button onclick="addCourse()"
                    class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __tool('gpa-calculator', 'editor.btn_add_course') }}
                </button>
                <button onclick="calcGPA()"
                    class="px-8 py-2.5 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold text-sm shadow-lg">
                    {{ __tool('gpa-calculator', 'editor.btn_calculate') }}
                </button>
                <button onclick="resetAll()"
                    class="px-5 py-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-all font-semibold text-sm">
                    {{ __tool('gpa-calculator', 'editor.btn_reset') }}
                </button>
            </div>

            <div id="gpa-result" class="hidden">
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="bg-purple-50 rounded-xl p-6 text-center border border-purple-200">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('gpa-calculator', 'editor.label_result') }}</div>
                        <div class="text-5xl font-black text-purple-700" id="gpa-value">0.00</div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-5 text-center border border-blue-200">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('gpa-calculator', 'editor.label_total_credits') }}
                        </div>
                        <div class="text-3xl font-black text-blue-700" id="gpa-credits">0</div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-5 text-center border border-green-200">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('gpa-calculator', 'editor.label_total_points') }}
                        </div>
                        <div class="text-3xl font-black text-green-700" id="gpa-points">0</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Long-Form SEO Content --}}
        @php $content = __tool('gpa-calculator', 'content'); @endphp
        @if(is_array($content))
            <div class="space-y-8">
                <div
                    class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                    <h2 class="text-3xl font-black text-gray-900 mb-4 text-center">{{ $content['what_title'] ?? '' }}</h2>
                    <p class="text-gray-600 text-lg leading-relaxed text-center mx-auto max-w-3xl">
                        {{ $content['what_text'] ?? '' }}</p>
                </div>

                {{-- GPA Scale --}}
                @if(!empty($content['scale_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['scale_title'] }}</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-purple-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-purple-700">Grade</th>
                                        <th class="px-4 py-3 text-center font-semibold text-purple-700">Points</th>
                                        <th class="px-4 py-3 text-right font-semibold text-purple-700">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($content['scale'] ?? [] as $row)
                                        <tr class="border-t border-gray-100 hover:bg-gray-50">
                                            <td class="px-4 py-2 font-semibold text-gray-700">{{ $row['grade'] }}</td>
                                            <td class="px-4 py-2 text-center font-mono text-purple-600">{{ $row['points'] }}</td>
                                            <td class="px-4 py-2 text-right text-gray-500">{{ $row['percent'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                @if(!empty($content['section1_title']))
                    <div
                        class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-3xl p-8 md:p-12 shadow-xl border border-indigo-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['section1_title'] }}</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $content['section1_text'] ?? '' }}</p>
                    </div>
                @endif

                @if(!empty($content['section2_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section2_title'] }}</h2>
                        @if(!empty($content['section2_items']))
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($content['section2_items'] as $item)
                                    <div
                                        class="bg-gradient-to-br from-gray-50 to-purple-50 rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-shadow">
                                        <h3 class="font-bold text-purple-700 text-lg mb-2">{{ $item['title'] }}</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $item['text'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($content['section3_title']))
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 md:p-12 shadow-xl border border-green-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section3_title'] }}</h2>
                        @if(!empty($content['section3_items']))
                            <div class="space-y-3">
                                @foreach($content['section3_items'] as $tip)
                                    <div class="flex items-start gap-3 bg-white rounded-xl p-4 shadow-sm">
                                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700 text-sm">{{ $tip }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($content['section4_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['section4_title'] }}</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $content['section4_text'] ?? '' }}</p>
                    </div>
                @endif

                @if(!empty($content['faq_title']))
                    <div
                        class="bg-gradient-to-br from-gray-50 to-purple-50 rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ $content['faq_title'] }}</h2>
                        @if(!empty($content['faqs']))
                            <div class="space-y-4 max-w-3xl mx-auto">
                                @foreach($content['faqs'] as $faq)
                                    <details class="bg-white rounded-xl shadow-sm border border-gray-200 group">
                                        <summary
                                            class="cursor-pointer px-6 py-4 font-semibold text-gray-800 flex justify-between items-center">
                                            {{ $faq['q'] }}
                                            <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </summary>
                                        <div class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">{{ $faq['a'] }}</div>
                                    </details>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function addCourse() {
                const container = document.getElementById('gpa-courses');
                const row = container.querySelector('.gpa-row').cloneNode(true);
                row.querySelector('.gpa-name').value = '';
                row.querySelector('.gpa-grade').selectedIndex = 0;
                row.querySelector('.gpa-credits').value = '3';
                container.appendChild(row);
            }

            function calcGPA() {
                const rows = document.querySelectorAll('.gpa-row');
                let totalPoints = 0, totalCredits = 0;
                rows.forEach(row => {
                    const grade = parseFloat(row.querySelector('.gpa-grade').value);
                    const credits = parseFloat(row.querySelector('.gpa-credits').value) || 0;
                    totalPoints += grade * credits;
                    totalCredits += credits;
                });
                if (totalCredits === 0) return;
                const gpa = totalPoints / totalCredits;
                document.getElementById('gpa-value').innerText = gpa.toFixed(2);
                document.getElementById('gpa-credits').innerText = totalCredits;
                document.getElementById('gpa-points').innerText = totalPoints.toFixed(1);
                document.getElementById('gpa-result').classList.remove('hidden');
            }

            function resetAll() {
                const container = document.getElementById('gpa-courses');
                const rows = container.querySelectorAll('.gpa-row');
                while (rows.length > 1) rows[rows.length - 1].remove();
                rows[0].querySelector('.gpa-name').value = '';
                rows[0].querySelector('.gpa-grade').selectedIndex = 0;
                rows[0].querySelector('.gpa-credits').value = '3';
                document.getElementById('gpa-result').classList.add('hidden');
            }
        </script>
    @endpush
@endsection