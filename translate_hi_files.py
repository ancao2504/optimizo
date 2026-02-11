import os
import re
import json

# Comprehensive mapping of common English words to Hindi (Devanagari)
# Focusing on technical terms used as labels/descriptions
TRANSLATIONS = {
    "title": "शीर्षक",
    "desc": "विवरण",
    "description": "विवरण",
    "subtitle": "उपशीर्षक",
    "content": "सामग्री",
    "usage": "उपयोग",
    "uses": "उपयोग",
    "features": "विशेषताएं",
    "feature": "विशेषता",
    "example": "उदाहरण",
    "examples": "उदाहरण",
    "step": "चरण",
    "steps": "चरण",
    "label": "लेबल",
    "success": "सफलता",
    "error": "त्रुटि",
    "errors": "त्रुटियाँ",
    "warning": "चेतावनी",
    "copy": "कॉपी",
    "copied": "कॉपी किया गया",
    "paste": "पेस्ट",
    "input": "इनपुट",
    "output": "आउटपुट",
    "format": "फॉर्मेट",
    "formats": "फॉर्मेट्स",
    "data": "डेटा",
    "result": "परिणाम",
    "results": "परिणाम",
    "button": "बटन",
    "submit": "सबमिट",
    "cancel": "रद्द करें",
    "save": "सेव",
    "download": "डाउनलोड",
    "upload": "अपलोड",
    "generate": "जनरेट",
    "generator": "जेनरेटर",
    "convert": "कन्वर्ट",
    "converter": "कन्वर्टर",
    "check": "चेक",
    "checker": "चेकर",
    "verify": "सत्यापित",
    "validate": "मान्य",
    "clear": "साफ़ करें",
    "reset": "रीसेट",
    "search": "खोज",
    "status": "स्थिति",
    "active": "सक्रिय",
    "inactive": "निष्क्रिय",
    "available": "उपलब्ध",
    "unavailable": "अनुपलब्ध",
    "registration": "पंजीकरण",
    "registered": "पंजीकृत",
    "login": "लॉगिन",
    "logout": "लॉगआउट",
    "profile": "प्रोफ़ाइल",
    "settings": "सेटिंग्स",
    "tools": "टूल्स",
    "resolution": "रेज़ोल्यूशन",
    "resolutions": "रेज़ोल्यूशन",
    "quality": "गुणवत्ता",
    "preview": "पूर्वावलोकन",
    "thumbnail": "थंबनेल",
    "thumbnails": "थंबनेल",
    "video": "वीडियो",
    "videos": "वीडियो",
    "channel": "चैनल",
    "user": "उपयोगकर्ता",
    "password": "पासवर्ड",
    "username": "उपयोगकर्ता नाम",
    "email": "ईमेल",
    "name": "नाम",
    "link": "लिंक",
    "links": "लिंक",
    "broken": "टूटा हुआ",
    "redirect": "रीडायरेक्ट",
    "placeholder": "प्लेसहोल्डर",
    "hero": "हीरो",
    "section": "अनुभाग",
    "free": "मुफ्त",
    "fast": "तेज़",
    "secure": "सुरक्षित",
    "security": "सुरक्षा",
    "privacy": "गोपनीयता",
    "integrity": "अखंडता",
    "analyze": "विश्लेषण",
    "analysis": "विश्लेषण",
    "instant": "तुरंत",
    "loading": "लोड हो रहा है",
    "empty": "खाली",
    "valid": "मान्य",
    "invalid": "अमान्य",
    "total": "कुल",
    "count": "गिनती",
    "size": "आकार",
    "bits": "बिट्स",
    "rounds": "राउंड",
    "round": "राउंड",
    "time": "समय",
    "date": "तारीख",
    "tips": "टिप्स",
    "tip": "टिप",
    "metadata": "मेटाडेटा",
    "tags": "टैग",
    "tag": "टैग",
    "hash": "हैश",
    "hashes": "हैश",
    "checksum": "चेकसम",
    "encoding": "एन्कोडिंग",
    "decoding": "डिकोडिंग",
    "encryption": "एन्क्रिप्शन",
    "decryption": "डिक्रिप्शन",
    "support": "समर्थन",
    "character": "वर्ण",
    "characters": "वर्ण",
    "case": "केस",
    "transparency": "पारदर्शिता",
    "transparent": "पारदर्शी",
    "compression": "संपीड़न",
    "transform": "ट्रांसफॉर्म",
    "based": "आधारित",
    "story": "कहानी",
    "revenue": "राजस्व",
    "limit": "सीमा",
    "limits": "सीमाएं",
    "system": "सिस्टम",
    "systems": "सिस्टम",
    "location": "स्थान",
    "design": "डिज़ाइन",
    "presentation": "प्रेजेंटेशन",
    "presentations": "प्रेजेंटेशन",
    "articles": "लेख",
    "article": "लेख",
    "blog": "ब्लॉग",
    "articles": "लेख",
    "educational": "शैक्षिक",
    "personal": "व्यक्तिगत",
    "commercial": "व्यावसायिक",
    "professional": "पेशेवर",
    "legal": "कानूनी",
    "permission": "अनुमति",
    "copyright": "कॉपीराइट",
    "violate": "उल्लंघन",
    "original": "मूल",
    "installation": "इंस्टॉलेशन",
    "software": "सॉफ्टवेयर",
    "public": "सार्वजनिक",
    "private": "निजी",
    "shared": "साझा",
    "best": "सर्वश्रेष्ठ",
    "practices": "अभ्यास",
    "standard": "मानक",
    "main": "मुख्य",
    "about": "के बारे में",
    "contact": "संपर्क",
    "terms": "शर्तें",
    "services": "सेवाएँ",
    "rights": "अधिकार",
    "reserved": "आरक्षित",
    "follow": "फ़ॉलो",
    "newsletter": "न्यूज़लेटर",
    "subscribe": "सब्सक्राइब",
    "footer": "फुटर",
    "company": "कंपनी",
    "legal": "कानूनी",
    "here": "यहाँ",
    "suffix": "प्रत्यय",
    "analyzers": "एनालाइज़र",
    "generators": "जेनरेटर",
    "converters": "कन्वर्टर",
    "online": "ऑनलाइन",
    "keywords": "कीवर्ड",
    "keyword": "कीवर्ड",
    "checker": "चेकर",
    "analyzer": "एनालाइज़र",
    "generator": "जेनरेटर",
    "converters": "कन्वर्टर",
    "analyzer": "एनालाइज़र",
    "generator": "जेनरेटर",
    "converter": "कन्वर्टर",
}

# Preserve technical acronyms and brands
PRESERVED = {
    "HD", "4K", "URL", "URLs", "API", "APIs", "JSON", "HTML", "CSS", "PHP", "SQL",
    "PDF", "WebP", "AVIF", "HEIC", "SVG", "PNG", "JPEG", "JPG", "TIFF", "GIF",
    "UTC", "ISP", "DNS", "WHOIS", "SERP", "HTTP", "HTTPS", "Mbps", "GB", "MB", "KB",
    "QR", "SEO", "IP", "ISP", "XLSX", "XLS", "CSV", "TSV", "XML", "YAML",
    "YouTube", "Google", "Twitter", "Facebook", "LinkedIn", "WhatsApp", "Instagram",
    "Bing", "Yahoo", "Optimizo", "Windows", "Unix", "Adler", "Tiger", "RIPEMD",
    "GOST", "Snefru", "Whirlpool", "Merkle", "Base64", "ASCII", "Unicode", "EXIF"
}

def translate_match(match):
    word = match.group(0)
    # Check exact match first
    if word in PRESERVED:
        return word
    
    # Check lowercase mapping
    lower_word = word.lower()
    if lower_word in TRANSLATIONS:
        # Preserve capitalization if simple (Title Case)
        translated = TRANSLATIONS[lower_word]
        return translated
    
    return word

def process_file(file_path):
    print(f"Processing {file_path}")
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Replace words (4+ characters, boundaries)
        # Regex to find words in Latin script
        new_content = re.sub(r'\b[a-zA-Z]{4,}\b', translate_match, content)
        
        if new_content != content:
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(new_content)
            return True
    except Exception as e:
        print(f"Error processing {file_path}: {e}")
    return False

def main():
    base_path = r'd:\workspace\optimizo\resources\lang\hi'
    modified_count = 0
    for root, dirs, files in os.walk(base_path):
        for file in files:
            if file.endswith('.json') or file.endswith('.php'):
                if process_file(os.path.join(root, file)):
                    modified_count += 1
    print(f"Finished. Modified {modified_count} files.")

if __name__ == "__main__":
    main()
