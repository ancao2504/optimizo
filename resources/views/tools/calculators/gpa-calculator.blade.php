@extends('layouts.app')

@section('title', __tool('gpa-calculator', 'meta.title'))
@section('meta_description', __tool('gpa-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="gpa-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <div id="courses-container">
                <div class="course-row grid grid-cols-12 gap-3 mb-3 items-end">
                    <div class="col-span-5">
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('gpa-calculator', 'editor.label_course') }}</label>
                        <input type="text"
                            class="course-name w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            placeholder="{{ __tool('gpa-calculator', 'editor.placeholder_course') }}">
                    </div>
                    <div class="col-span-3">
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('gpa-calculator', 'editor.label_grade') }}</label>
                        <select
                            class="course-grade w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            <option value="4.0">A+ / A</option>
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
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('gpa-calculator', 'editor.label_credits') }}</label>
                        <input type="number"
                            class="course-credits w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            value="3" min="1" max="10">
                    </div>
                    <div class="col-span-2 flex justify-end">
                        <button onclick="removeCourse(this)"
                            class="px-3 py-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 mb-6 mt-4">
                <button onclick="addCourse()"
                    class="px-6 py-3 bg-green-100 text-green-700 rounded-xl hover:bg-green-200 transition-all font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ __tool('gpa-calculator', 'editor.btn_add_course') }}
                </button>
                <button onclick="calculateGPA()"
                    class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    {{ __tool('gpa-calculator', 'editor.btn_calculate') }}
                </button>
                <button onclick="resetAll()"
                    class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    {{ __tool('gpa-calculator', 'editor.btn_reset') }}
                </button>
            </div>

            <!-- Result -->
            <div id="gpa-result" class="hidden">
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="bg-purple-50 rounded-xl p-5 text-center border border-purple-200">
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

        @php $content = __tool('gpa-calculator', 'content'); @endphp
        @if(is_array($content))
            <div
                class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                <h2 class="text-3xl font-black text-gray-900 mb-3 text-center">{{ $content['what_title'] ?? '' }}</h2>
                <p class="text-gray-600 text-center mx-auto max-w-xl mb-8">{{ $content['what_text'] ?? '' }}</p>

                @if(!empty($content['scale']))
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">{{ $content['scale_title'] ?? '' }}</h3>
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-gray-600 font-semibold">Grade</th>
                                    <th class="px-4 py-3 text-center text-gray-600 font-semibold">Points</th>
                                    <th class="px-4 py-3 text-center text-gray-600 font-semibold">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($content['scale'] as $s)
                                    <tr class="border-t border-gray-100">
                                        <td class="px-4 py-2 font-semibold text-gray-700">{{ $s['grade'] }}</td>
                                        <td class="px-4 py-2 text-center font-mono">{{ $s['points'] }}</td>
                                        <td class="px-4 py-2 text-center text-gray-500">{{ $s['percent'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function addCourse() {
                const container = document.getElementById('courses-container');
                const row = container.querySelector('.course-row').cloneNode(true);
                row.querySelector('.course-name').value = '';
                row.querySelector('.course-credits').value = '3';
                row.querySelector('.course-grade').selectedIndex = 0;
                container.appendChild(row);
            }

            function removeCourse(btn) {
                const rows = document.querySelectorAll('.course-row');
                if (rows.length > 1) btn.closest('.course-row').remove();
            }

            function resetAll() {
                const container = document.getElementById('courses-container');
                const rows = container.querySelectorAll('.course-row');
                for (let i = rows.length - 1; i > 0; i--) rows[i].remove();
                const first = rows[0];
                first.querySelector('.course-name').value = '';
                first.querySelector('.course-credits').value = '3';
                first.querySelector('.course-grade').selectedIndex = 0;
                document.getElementById('gpa-result').classList.add('hidden');
            }

            function calculateGPA() {
                const rows = document.querySelectorAll('.course-row');
                let totalPoints = 0, totalCredits = 0;

                rows.forEach(row => {
                    const grade = parseFloat(row.querySelector('.course-grade').value);
                    const credits = parseInt(row.querySelector('.course-credits').value) || 0;
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
        </script>
    @endpush
@endsection