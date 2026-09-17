<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WhatsAppChatController;
use App\Http\Controllers\WhatsAppWebhookController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\AboutPage;
use App\Models\BankAccount;
use App\Settings\GeneralSettings;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function (GeneralSettings $settings) {
    return Inertia::render(
        'Home',
        [
            'categories' => Category::with('products')->get(),
            'bank_details' => BankAccount::all(),

            'global_discount' => $settings->global_discount,
            'starting_year' => $settings->starting_year,
            'min_order_value' => $settings->min_order_value,
            'mobile_number_1' => $settings->mobile_number_1,
            'mobile_number_2' => $settings->mobile_number_2,
            'marquee_content' => $settings->marquee_content,
            'company_address' => $settings->company_address,

        ]
);
})->name('home');

// Checkout is now inline on the Home page

// Route::post('/order', function () {
//     return Inertia::render(
//         'Order'
//     );

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/admin/orders/{id}/print', [OrderController::class, 'printOrder'])->name('admin.orders.print');
Route::get('/admin/orders/{id}/download', [OrderController::class, 'downloadOrder'])->name('admin.orders.download');
Route::get('/admin/orders/bulk-download', [OrderController::class, 'bulkPdfDownload'])->name('orders.bulk-download');

Route::get('/thankyou/{order}', function (Order $order, GeneralSettings $settings) {
    $order->load('customer', 'items.product');

    return Inertia::render('Thankyou', [
        'orderId' => $order->id,
        'customerName' => $order->customer->name,
        'whatsappNumber' => $order->customer->whatsapp_number,
        'netTotal' => $order->net_total,
        'items' => $order->items->map(fn ($item) => [
            'name' => $item->product->name,
            'quantity' => $item->quantity,
            'total' => $item->total,
        ]),
        'companyWhatsappNumber' => $settings->mobile_number_1,
    ]);
})->name('thankyou');


Route::get('/about', function (GeneralSettings $settings) {
    return Inertia::render(
        'About',[

            'about_page' => AboutPage::all(),
            'mobile_number_1' => $settings->mobile_number_1,
            'mobile_number_2' => $settings->mobile_number_2,
            'company_address' => $settings->company_address,

        ]
);
})->name('about');

Route::get('/contact', function (GeneralSettings $settings) {
    return Inertia::render(
        'Contact',[
            'mobile_number_1' => $settings->mobile_number_1,
            'mobile_number_2' => $settings->mobile_number_2,
            'company_address' => $settings->company_address,
            'company_email' => $settings->company_email,
        ]
);
})->name('contact');

Route::post('/contact-form', [ContactController::class, 'saveContact'])->name('contact-form');

Route::get('/order-now', function (GeneralSettings $settings) {
    return Inertia::render('OrderNow', [
        'categories' => Category::with('products')->get(),
        'global_discount' => $settings->global_discount,
        'min_order_value' => $settings->min_order_value,
        'mobile_number_1' => $settings->mobile_number_1,
        'mobile_number_2' => $settings->mobile_number_2,
        'company_address' => $settings->company_address,
    ]);
})->name('order-now');

Route::get('/faq', function (GeneralSettings $settings) {
    return Inertia::render('Faq', [
        'mobile_number_1' => $settings->mobile_number_1,
        'mobile_number_2' => $settings->mobile_number_2,
        'company_address' => $settings->company_address,
    ]);
})->name('faq');

Route::get('/blog', function (GeneralSettings $settings) {
    return Inertia::render('Blog', [
        'mobile_number_1' => $settings->mobile_number_1,
        'mobile_number_2' => $settings->mobile_number_2,
        'company_address' => $settings->company_address,
    ]);
})->name('blog');

Route::get('/blog/{slug}', function (string $slug, GeneralSettings $settings) {
    $posts = json_decode(file_get_contents(resource_path('js/data/blogPosts.json')), true);
    $post = collect($posts)->firstWhere('slug', $slug);

    if (!$post) {
        abort(404);
    }

    return Inertia::render('BlogPost', [
        'post' => $post,
        'mobile_number_1' => $settings->mobile_number_1,
        'mobile_number_2' => $settings->mobile_number_2,
        'company_address' => $settings->company_address,
    ]);
})->name('blog.show');

Route::get('/privacy-policy', function (GeneralSettings $settings) {
    return Inertia::render('PrivacyPolicy', [
        'mobile_number_1' => $settings->mobile_number_1,
        'mobile_number_2' => $settings->mobile_number_2,
        'company_address' => $settings->company_address,
    ]);
})->name('privacy-policy');

Route::get('/safety-tips', function (GeneralSettings $settings) {
    return Inertia::render('SafetyTips', [
        'mobile_number_1' => $settings->mobile_number_1,
        'mobile_number_2' => $settings->mobile_number_2,
        'company_address' => $settings->company_address,
    ]);
})->name('safety-tips');

Route::get('/pricelist', [CategoryController::class, 'downloadPdf'])->name('pricelist');

Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
        ['loc' => url('/about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['loc' => url('/faq'), 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['loc' => url('/blog'), 'priority' => '0.9', 'changefreq' => 'weekly'],
        ['loc' => url('/contact'), 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['loc' => url('/privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
    ];

    // Add individual blog post URLs
    $posts = json_decode(file_get_contents(resource_path('js/data/blogPosts.json')), true);
    foreach ($posts as $post) {
        $urls[] = ['loc' => url('/blog/' . $post['slug']), 'priority' => '0.7', 'changefreq' => 'monthly'];
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($urls as $url) {
        $xml .= '<url>';
        $xml .= '<loc>' . $url['loc'] . '</loc>';
        $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
        $xml .= '<priority>' . $url['priority'] . '</priority>';
        $xml .= '<lastmod>' . now()->toDateString() . '</lastmod>';
        $xml .= '</url>';
    }
    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml']);
});

// WhatsApp templates now managed via Filament Resource at /admin/whats-app-templates

// WhatsApp Webhook (no CSRF - Meta sends POST)
Route::get('/webhook/whatsapp', [WhatsAppWebhookController::class, 'verify']);
Route::post('/webhook/whatsapp', [WhatsAppWebhookController::class, 'handle']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/reports',[ProductController::class, 'selectedOrders'])->name('orders.SelectedOrders');