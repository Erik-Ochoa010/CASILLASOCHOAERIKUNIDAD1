from django.shortcuts import render, redirect, get_object_or_404
from django.contrib.auth.models import User
from django.contrib.auth import authenticate, login, logout
from django.contrib import messages
from django.http import JsonResponse
from django.contrib.auth.decorators import login_required
from django.views.decorators.http import require_POST
from django.db.models import Q

from .forms import RegistroForm, MessageForm, ProfileUpdateForm
from .models import Message, Profile, Friend, FriendRequest



# --- Vistas de Inicio y Páginas Básicas ---

from .forms import CaptchaTestForm  # importa el formulario

def captcha_gate(request):
    if request.method == 'POST':
        form = CaptchaTestForm(request.POST)
        if form.is_valid():
            request.session['passed_captcha'] = True
            return redirect('index')
    else:
        form = CaptchaTestForm()

    return render(request, 'core/captcha_gate.html', {'form': form})

def index(request):
    if not request.session.get('passed_captcha', False):
        return redirect('captcha_gate')

    context = {
        'featured_users': User.objects.filter(profile__isnull=False).order_by('?')[:5]
    }
    return render(request, 'core/index.html', context)

def contacto(request):
    return render(request, 'core/contacto.html')

def recuperacion(request):
    return render(request, 'core/recuperacion.html')

def mapa_sitio(request):
    return render(request, 'core/mapa_sitio.html')

def faq(request):
    categories = {
        'Registro': ['¿Cómo me registro?', '¿Qué datos necesito?'],
        'Mensajes': ['¿Cómo envío mensajes?', '¿Puedo eliminar mensajes?']
    }
    return render(request, 'core/faq.html', {'categories': categories})

def bosserver(request):
    return render(request, 'core/bosserver.html')


# --- Login y Registro ---

def login_register(request):
    # Verificar si ya pasó el captcha
    if not request.session.get('passed_captcha', False):
        return redirect('captcha_gate')

    form = RegistroForm()
    return render(request, 'core/login_register.html', {'form': form})

def register_view(request):
    # Verificar si ya pasó el captcha
    if not request.session.get('passed_captcha', False):
        return redirect('captcha_gate')

    if request.method == 'POST':
        form = RegistroForm(request.POST)
        if form.is_valid():
            user = form.save(commit=False)
            user.set_password(form.cleaned_data['password'])
            user.save()
            messages.success(request, "¡Registro exitoso! Ahora puedes iniciar sesión.")
            return redirect('login_register')
        else:
            messages.error(request, "Por favor corrige los errores en el formulario.")
    else:
        form = RegistroForm()
    return render(request, 'core/login_register.html', {'form': form})

def login_view(request):
    # Verificar si ya pasó el captcha
    if not request.session.get('passed_captcha', False):
        return redirect('captcha_gate')

    if request.method == 'POST':
        username = request.POST.get('username')
        password = request.POST.get('password')
        user = authenticate(request, username=username, password=password)
        if user is not None:
            login(request, user)
            messages.success(request, f"¡Bienvenido de vuelta, {user.first_name}!")
            return redirect('index')
        else:
            messages.error(request, "Credenciales inválidas. Intenta nuevamente.")
            form = RegistroForm()
            return render(request, 'core/login_register.html', {'form': form})
    return redirect('login_register')

@login_required
def logout_view(request):
    logout(request)
    # Eliminar el flag del captcha para obligar a verificar de nuevo al iniciar sesión
    if 'passed_captcha' in request.session:
        del request.session['passed_captcha']
    messages.info(request, "Has cerrado sesión correctamente.")
    return redirect('index')


# --- Perfil ---

@login_required
def profile_view(request):
    profile, _ = Profile.objects.get_or_create(user=request.user)
    if request.method == 'POST':
        form = ProfileUpdateForm(request.POST, request.FILES, instance=profile)
        if form.is_valid():
            form.save()
            messages.success(request, "Perfil actualizado correctamente.")
            return redirect('profile')
    else:
        form = ProfileUpdateForm(instance=profile)
    return render(request, 'core/profile.html', {'form': form})


# --- Mensajes ---

@login_required
def message_list(request):
    profile = request.user.profile
    conversations = Message.objects.filter(recipient=profile).order_by('-timestamp')
    return render(request, 'core/message_list.html', {'conversations': conversations})

@login_required
def messages_with_user(request, user_id):
    other_user = get_object_or_404(User, id=user_id)
    user_profile = request.user.profile
    other_profile = other_user.profile

    if request.method == 'POST':
        form = MessageForm(request.POST)
        if form.is_valid():
            Message.objects.create(
                sender=user_profile,
                recipient=other_profile,
                content=form.cleaned_data['content']
            )
            if request.headers.get('X-Requested-With') == 'XMLHttpRequest':
                return JsonResponse({'status': 'success'})
            return redirect('messages_with_user', user_id=user_id)

    # Marcar mensajes como leídos
    Message.objects.filter(
        recipient=user_profile,
        sender=other_profile,
        is_read=False
    ).update(is_read=True)

    messages_between = Message.objects.filter(
        Q(sender=user_profile, recipient=other_profile) |
        Q(sender=other_profile, recipient=user_profile)
    ).order_by('timestamp')

    form = MessageForm()
    context = {
        'messages': messages_between,
        'recipient': other_user,
        'form': form
    }

    if request.headers.get('X-Requested-With') == 'XMLHttpRequest':
        return render(request, 'core/partials/message_list.html', context)

    return render(request, 'core/messages_with_user.html', context)

@login_required
@require_POST
def delete_message(request, message_id):
    message = get_object_or_404(Message, id=message_id, sender=request.user.profile)
    message.delete()
    return JsonResponse({'status': 'success'})


# --- Gestión de Amigos ---

@login_required
def amigos(request):
    friends = Friend.objects.filter(owner=request.user.profile)
    received_requests = FriendRequest.objects.filter(to_user=request.user, accepted=False)
    return render(request, 'core/amigos.html', {
        'friends': friends,
        'received_requests': received_requests,
    })

@login_required
def add_friend(request):
    if request.method == 'POST':
        username = request.POST.get('username')
        if username == request.user.username:
            messages.error(request, "No te puedes agregar a ti mismo.")
            return redirect('amigos')

        try:
            user_to_add = User.objects.get(username=username)
            profile_to_add = user_to_add.profile
            owner_profile = request.user.profile

            if Friend.objects.filter(owner=owner_profile, friend=profile_to_add).exists():
                messages.info(request, f"{username} ya es tu amigo.")
            else:
                Friend.objects.create(owner=owner_profile, friend=profile_to_add)
                messages.success(request, f"{username} fue agregado como amigo.")
        except User.DoesNotExist:
            messages.error(request, "Usuario no encontrado.")
    return redirect('amigos')

@login_required
def remove_friend(request, user_id):
    if request.method == 'POST':
        friend = get_object_or_404(Friend, owner=request.user.profile, friend__id=user_id)
        friend.delete()
        messages.success(request, "Amigo eliminado.")
    return redirect('amigos')

@login_required
def accept_request(request, request_id):
    friend_request = get_object_or_404(FriendRequest, id=request_id, to_user=request.user)
    
    Friend.objects.create(owner=request.user.profile, friend=friend_request.from_user.profile)
    Friend.objects.create(owner=friend_request.from_user.profile, friend=request.user.profile)
    
    friend_request.accepted = True
    friend_request.save()
    
    messages.success(request, "Solicitud de amistad aceptada.")
    return redirect('amigos')

@login_required
def send_message(request, user_id):
    if request.method == 'POST':
        message_text = request.POST.get('message')
        receiver = get_object_or_404(User, id=user_id)
        Message.objects.create(
            sender=request.user.profile,
            recipient=receiver.profile,
            content=message_text
        )
        messages.success(request, "Mensaje enviado.")
    return redirect('amigos')
