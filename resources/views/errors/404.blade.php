@extends('layouts.app')

@section('title', 'Pages Not Found - Optimizo')
@section('meta_description', 'The page you are looking for could not be found.')

@push('styles')
    <style>
        .error-404-container {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 3rem 1rem;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f1ff 40%, #fdf2f8 100%);
        }

        /* Animated background blobs */
        .error-404-container::before,
        .error-404-container::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.3;
            pointer-events: none;
            z-index: 0;
        }

        .error-404-container::before {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            top: -10%;
            left: -5%;
            animation: blobFloat 8s ease-in-out infinite;
        }

        .error-404-container::after {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #ec4899, #f97316);
            bottom: -10%;
            right: -5%;
            animation: blobFloat 10s ease-in-out infinite reverse;
        }

        @keyframes blobFloat {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(30px, -20px) scale(1.1);
            }
        }

        .error-content {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 560px;
            margin: 0 auto;
        }

        /* Animated 404 illustration */
        .error-illustration {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .error-number {
            font-size: clamp(7rem, 18vw, 12rem);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 35%, #ec4899 65%, #f97316 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 4s ease infinite;
            user-select: none;
            letter-spacing: -0.03em;
            position: relative;
        }

        /* Glow behind the 404 */
        .error-number-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: clamp(7rem, 18vw, 12rem);
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, #6366f1, #a855f7, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: blur(40px);
            opacity: 0.35;
            pointer-events: none;
            user-select: none;
            z-index: -1;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Orbiting ring */
        .orbit-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 110%;
            height: 110%;
            transform: translate(-50%, -50%);
            border: 2px dashed rgba(99, 102, 241, 0.15);
            border-radius: 50%;
            animation: orbitSpin 20s linear infinite;
            pointer-events: none;
        }

        .orbit-dot {
            position: absolute;
            top: -5px;
            left: 50%;
            width: 10px;
            height: 10px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-radius: 50%;
            box-shadow: 0 0 12px rgba(99, 102, 241, 0.5);
        }

        @keyframes orbitSpin {
            from {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Divider */
        .error-divider {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #ec4899);
            border-radius: 999px;
            margin: 0 auto 1.25rem;
        }

        .error-subtitle {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .error-description {
            font-size: 1.05rem;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 2rem;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Buttons */
        .error-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 0.875rem;
        }

        .btn-home-404 {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.75rem;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            border-radius: 12px;
            border: none;
            text-decoration: none;
            box-shadow: 0 6px 24px rgba(99, 102, 241, 0.3);
            transition: all 0.3s ease;
        }

        .btn-home-404:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(99, 102, 241, 0.4);
            color: #fff;
            text-decoration: none;
        }

        .btn-tools-404 {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.75rem;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            color: #475569;
            font-weight: 700;
            font-size: 0.95rem;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-tools-404:hover {
            border-color: #a5b4fc;
            color: #6366f1;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.1);
            text-decoration: none;
        }

        /* Floating dots decoration */
        .floating-dots {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }

        .dot {
            position: absolute;
            border-radius: 50%;
            opacity: 0;
            animation: dotFloat linear infinite;
        }

        @keyframes dotFloat {
            0% {
                opacity: 0;
                transform: translateY(0) scale(0.5);
            }

            15% {
                opacity: 0.5;
            }

            85% {
                opacity: 0.5;
            }

            100% {
                opacity: 0;
                transform: translateY(-100vh) scale(1);
            }
        }

        /* Entrance animation */
        .fade-in-up {
            opacity: 0;
            transform: translateY(24px);
            animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.35s;
        }

        .delay-4 {
            animation-delay: 0.5s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 640px) {
            .error-subtitle {
                font-size: 1.3rem;
            }

            .error-description {
                font-size: 0.95rem;
            }

            .error-actions {
                flex-direction: column;
            }

            .btn-home-404,
            .btn-tools-404 {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="error-404-container">
        {{-- Floating dots --}}
        <div class="floating-dots" id="floating-dots-404"></div>

        <div class="error-content">
            {{-- 404 Number with glow + orbit --}}
            <div class="error-illustration fade-in-up">
                <div class="error-number-glow">404</div>
                <div class="error-number">404</div>
                <div class="orbit-ring">
                    <div class="orbit-dot"></div>
                </div>
            </div>

            {{-- Divider line --}}
            <div class="error-divider fade-in-up delay-1"></div>

            {{-- Heading --}}
            <h1 class="error-subtitle fade-in-up delay-2">
                Oops! Page Not Found
            </h1>

            {{-- Description --}}
            <p class="error-description fade-in-up delay-3">
                The page you're looking for might have been removed, renamed, or is temporarily unavailable. Let's get you
                back on track.
            </p>

            {{-- Action buttons --}}
            <div class="error-actions fade-in-up delay-4">
                <a href="{{ localeRoute('home') }}" class="btn-home-404">
                    <i class="fas fa-home"></i>
                    <span>Back to Home</span>
                </a>
                <a href="{{ localeRoute('home') }}" class="btn-tools-404">
                    <i class="fas fa-tools"></i>
                    <span>Explore Tools</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('floating-dots-404');
            if (!container) return;

            const colors = ['#6366f1', '#a855f7', '#ec4899', '#06b6d4', '#f97316'];

            for (let i = 0; i < 15; i++) {
                const dot = document.createElement('div');
                dot.className = 'dot';
                const size = Math.random() * 6 + 3;
                dot.style.cssText = `
                            width: ${size}px;
                            height: ${size}px;
                            left: ${Math.random() * 100}%;
                            top: ${Math.random() * 100}%;
                            background: ${colors[Math.floor(Math.random() * colors.length)]};
                            animation-duration: ${Math.random() * 10 + 8}s;
                            animation-delay: ${Math.random() * 5}s;
                        `;
                container.appendChild(dot);
            }
        });
    </script>
@endpush