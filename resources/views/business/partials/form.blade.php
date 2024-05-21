<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $business->name ?? '') }}" required>
</div>
<div class="form-group">
    <label for="user_id">User ID</label>
    <input type="text" class="form-control" id="user_id" name="user_id" value="{{ old('user_id', $business->user_id ?? '') }}" required>
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $business->email ?? '') }}" required>
</div>
<div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $business->phone ?? '') }}" required>
</div>
<div class="form-group">
    <label for="location">Location</label>
    <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $business->location ?? '') }}" required>
</div>
<div class="form-group">
    <label for="delivery">Delivery</label>
    <input type="text" class="form-control" id="delivery" name="delivery" value="{{ old('delivery', $business->delivery ?? '') }}" required>
</div>
<div class="form-group">
    <label for="pickup">Pickup</label>
    <input type="text" class="form-control" id="pickup" name="pickup" value="{{ old('pickup', $business->pickup ?? '') }}" required>
</div>
<div class="form-group">
    <label for="monday">Monday</label>
    <input type="text" class="form-control" id="monday" name="monday" value="{{ old('monday', $business->monday ?? '') }}" required>
</div>
<div class="form-group">
    <label for="tuesday">Tuesday</label>
    <input type="text" class="form-control" id="tuesday" name="tuesday" value="{{ old('tuesday', $business->tuesday ?? '') }}" required>
</div>
<div class="form-group">
    <label for="wednesday">Wednesday</label>
    <input type="text" class="form-control" id="wednesday" name="wednesday" value="{{ old('wednesday', $business->wednesday ?? '') }}" required>
</div>
<div class="form-group">
    <label for="thursday">Thursday</label>
    <input type="text" class="form-control" id="thursday" name="thursday" value="{{ old('thursday', $business->thursday ?? '') }}" required>
</div>
<div class="form-group">
    <label for="friday">Friday</label>
    <input type="text" class="form-control" id="friday" name="friday" value="{{ old('friday', $business->friday ?? '') }}" required>
</div>
<div class="form-group">
    <label for="saturday">Saturday</label>
    <input type="text" class="form-control" id="saturday" name="saturday" value="{{ old('saturday', $business->saturday ?? '') }}" required>
</div>
<div class="form-group">
    <label for="sunday">Sunday</label>
    <input type="text" class="form-control" id="sunday" name="sunday" value="{{ old('sunday', $business->sunday ?? '') }}" required>
</div>
<div class="form-group">
    <label for="business_status">Business Status</label>
    <input type="text" class="form-control" id="business_status" name="business_status" value="{{ old('business_status', $business->business_status ?? '') }}" required>
</div>
<div class="form-group">
    <label for="business_image">Business Image</label>
    <input type="text" class="form-control" id="business_image" name="business_image" value="{{ old('business_image', $business->business_image ?? '') }}" required>
</div>
<div class="form-group">
    <label for="logo_image">Logo Image</label>
    <input type="text" class="form-control" id="logo_image" name="logo_image" value="{{ old('logo_image', $business->logo_image ?? '') }}" required>
</div>
<div class="form-group">
    <label for="promo_images">Promo Images</label>
    <input type="text" class="form-control" id="promo_images" name="promo_images" value="{{ old('promo_images', $business->promo_images ?? '') }}" required>
</div>
<div class="form-group">
    <label for="category_id">Category ID</label>
    <input type="text" class="form-control" id="category_id" name="category_id" value="{{ old('category_id', $business->category_id ?? '') }}" required>
</div>
<div class="form-group">
    <label for="rating">Rating</label>
    <input type="text" class="form-control" id="rating" name="rating" value="{{ old('rating', $business->rating ?? '') }}" required>
</div>
<div class="form-group">
    <label for="delivery_time">Delivery Time</label>
    <input type="text" class="form-control" id="delivery_time" name="delivery_time" value="{{ old('delivery_time', $business->delivery_time ?? '') }}" required>
</div>
<div class="form-group">
    <label for="latitude">Latitude</label>
    <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $business->latitude ?? '') }}" required>
</div>
<div class="form-group">
    <label for="longitude">Longitude</label>
    <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $business->longitude ?? '') }}" required>
</div>
