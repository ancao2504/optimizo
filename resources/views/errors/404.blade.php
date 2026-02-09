@extends('layouts.app')

@section('title', 'Page Not Found - Optimizo')
@section('meta_description', 'The page you are looking for could not be found.')

@push('styles')
    <style>
        .error-404-container {
            min-height: 75vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 2rem 1rem;
        }

        /* Animated gradient orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            z-index: 0;
            pointer-events: none;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            top: 20%;
            left: 15%;
            animation: orbFloat1 8s ease-in-out infinite;
        }

        .orb-2 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #ec4899, #f97316);
            bottom: 10%;
            right: 10%;
            animation: orbFloat2 10s ease-in-out infinite;
        }

        .orb-3 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, #06b6d4, #6366f1);
            top: 50%;
            right: 30%;
            animation: orbFloat3 12s ease-in-out infinite;
        }

        @keyframes orbFloat1 {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(40px, -30px) scale(1.1);
            }
        }

        @keyframes orbFloat2 {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(-30px, 20px) scale(1.15);
            }
        }

        @keyframes orbFloat3 {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(20px, 40px) scale(0.9);
            }
        }

        /* 404 number */
        .error-number {
            font-size: clamp(8rem, 20vw, 14rem);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 30%, #ec4899 60%, #f97316 100%);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 6s ease infinite;
            user-select: none;
            position: relative;
            letter-spacing: -0.02em;
        }

        .error-number::after {
            content: '404';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: inherit;
            font-weight: inherit;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 30%, #ec4899 60%, #f97316 100%);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 6s ease infinite;
            filter: blur(30px);
            opacity: 0.4;
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

        /* Floating particles */
        .particles {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0;
            animation: particleFloat linear infinite;
        }

        @keyframes particleFloat {
            0% {
                opacity: 0;
                transform: translateY(100%) scale(0);
            }

            10% {
                opacity: 0.6;
            }

            90% {
                opacity: 0.6;
            }

            100% {
                opacity: 0;
                transform: translateY(-100vh) scale(1);
            }
        }

        /* Content area */
        .error-content {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
        }

        .error-subtitle {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 1rem;
            letter-spacing: -0.025em;
        }

        .error-description {
            font-size: 1.1rem;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 2.5rem;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Buttons */
        .error-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .btn-primary-404 {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 0.875rem;
            border: none;
            text-decoration: none;
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-primary-404::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #4f46e5, #9333ea);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-primary-404:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(99, 102, 241, 0.4);
        }

        .btn-primary-404:hover::before {
            opacity: 1;
        }

        .btn-primary-404 span,
        .btn-primary-404 svg {
            position: relative;
            z-index: 1;
        }

        .btn-secondary-404 {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            color: #475569;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 0.875rem;
            border: 1.5px solid #e2e8f0;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-secondary-404:hover {
            border-color: #a5b4fc;
            color: #6366f1;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.12);
        }

        /* Divider line */
        .error-divider {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #ec4899);
            border-radius: 999px;
            margin: 0 auto 1.5rem;
        }

        /* Entrance animations */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .fade-up-delay-1 {
            animation-delay: 0.15s;
        }

        .fade-up-delay-2 {
            animation-delay: 0.3s;
        }

        .fade-up-delay-3 {
            animation-delay: 0.45s;
        }

        .fade-up-delay-4 {
            animation-delay: 0.6s;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 640px) {
            .error-subtitle {
                font-size: 1.35rem;
            }

            .error-description {
                font-size: 1rem;
            }

            .error-actions {
                flex-direction: column;
            }

            .btn-primary-404,
            .btn-secondary-404 {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="error-404-container">
        {{-- Animated orbs --}}
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        {{-- Floating particles --}}
        <div class="particles" id="particles-404"></div>

        <div class="error-content">
            {{-- 404 Number --}}
            <div class="fade-up">
                <div class="error-number">404</div>
            </div>

            {{-- Divider --}}
            <div class="error-divider fade-up fade-up-delay-1"></div>

            {{-- Subtitle --}}
            <h2 class="error-subtitle fade-up fade-up-delay-2">
                Oops! Page Not Found
            </h2>

            {{-- Description --}}
            <p class="error-description fade-up fade-up-delay-3">
                The page you're looking for might have been removed, renamed, or is temporarily unavailable. Let's get you
                back on track.
            </p>

            {{-- Action Buttons --}}
            <div class="error-actions fade-up fade-up-delay-4">
                <a href="{{ localeRoute('home') }}" class="btn-primary-404">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                    </svg>
                    <span>Back to Home</span>
                </a>

                <a href="{{ localeRoute('tools') }}" class="btn-secondary-404">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    <span>Explore Tools</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Generate floating particles
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('particles-404');
            if (!container) return;

            const colors = ['#6366f1', '#a855f7', '#ec4899', '#06b6d4', '#f97316'];

            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                const size = Math.random() * 6 + 3;
                particle.style.cssText = `
                    width: ${size}px;
                    height: ${size}px;
                    left: ${Math.random() * 100}%;
                    background: ${colors[Math.floor(Math.random() * colors.length)]};
                    animation-duration: ${Math.random() * 8 + 6}s;
                    animation-delay: ${Math.random() * 6}s;
                `;
                container.appendChild(particle);
            }
        });
    </script>
@endpush