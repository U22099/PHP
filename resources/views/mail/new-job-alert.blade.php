<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Job Alert! - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #007bff;
            font-size: 24px;
            margin: 0 0 10px 0;
        }

        .header p {
            color: #666666;
            font-size: 14px;
            margin: 0;
        }

        .section-title {
            font-size: 20px;
            color: #333333;
            margin-bottom: 15px;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 10px;
        }

        .employer-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-left: 4px solid #007bff;
            border-radius: 4px;
        }

        .employer-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 20px;
            object-fit: cover;
        }

        .employer-details {
            flex-grow: 1;
        }

        .employer-details h3 {
            margin: 0 0 5px 0;
            font-size: 18px;
            color: #333333;
        }

        .employer-details p {
            margin: 0;
            font-size: 14px;
            color: #666666;
        }

        .employer-details p strong {
            color: #000000;
        }

        .job-details-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #eeeeee;
            border-radius: 4px;
        }

        .job-details-section h4 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #333333;
        }

        .job-details-section p,
        .job-details-section>.description {
            margin: 0 0 10px 0;
            font-size: 14px;
        }

        .job-details-section p strong {
            color: #000000;
        }

        .tags-container {
            margin-top: 15px;
            margin-bottom: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .tag {
            display: inline-block;
            background-color: #e0f7fa;
            color: #007bff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            line-height: 1;
        }

        .premium-note {
            text-align: center;
            font-size: 13px;
            color: #888888;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fffde7;
            border: 1px solid #ffecb3;
            border-radius: 4px;
        }

        .button {
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 16px;
            padding: 12px;
            background-color: #007bff;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #999999;
            margin-top: 20px;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .job-description-text {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 6;
            -webkit-box-orient: vertical;
        }
        .description-fallback {
            margin-top: 0.5rem;
            color: #4A5568;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>New Job Alert! 🚀</h1>
            <p>Great news! A new job matching your skills has just been posted on {{ config('app.name') }}.</p>
        </div>

        <div class="job-details-section">
            <h2 style="margin: 0 0 15px 0; font-size: 22px; color: #333333;">{{ $job->title }}</h2>

            <div class="employer-info">
                <img class="employer-image"
                    src="{{ $job->user->image ?? 'https://via.placeholder.com/60?text=Employer' }}"
                    alt="{{ $job->user->firstname }} {{ $job->user->lastname }}'s profile picture">
                <div class="employer-details">
                    <h3>Posted by: {{ $job->user->firstname }} {{ $job->user->lastname }}</h3>
                    <p><strong>Budget:</strong> {{ $job->currency->symbol }}<span>
                            @if ($job->min_budget === $job->max_budget)
                                {{ Number::abbreviate($job->min_budget, 1) }}
                            @else
                                {{ Number::abbreviate($job->min_budget, 1) }} -
                                {{ Number::abbreviate($job->max_budget, 1) }}
                            @endif
                        </span>
                        <span class="ml-2">in
                            {{ Illuminate\Support\Carbon::now()->addDays($job->time_budget)->diffForHumans(null, true) }}</span>
                    </p>
                </div>
            </div>

            <h4 style="margin-top: 20px;">Job Description:</h4>
            <div class="description prose job-description-text">
                @if ($job->description)
                    {{ $job->description }}
                @else
                    <p class="description-fallback">
                        A great opportunity for talented individuals. Click to learn more!
                    </p>
                @endif
            </div>

            @if ($job->tags->isNotEmpty())
                <h4 style="margin-top: 20px;">Required Skills:</h4>
                <div class="tags-container">
                    @foreach ($job->tags as $tag)
                        <span class="tag">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        <p class="premium-note">
            🔔 You're receiving this exclusive job alert because you have Job Alerts turned on, a premium feature
            designed for dedicated freelancers on {{ config('app.name') }}.
        </p>

        <a class="button" href="{{ route('jobs.show', $job->id) }}" target="_blank" rel="noopener noreferrer">View Job
            & Bid Now!</a>

        <div class="footer">
            <p>This is an automated notification. Please do not reply to this email.</p>
            <p>To manage your job alert preferences, please visit your profile settings on {{ config('app.name') }}.
            </p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
