# Seeder plugin for Craft CMS 3.x

![Seeder](/resources/banner.png?raw=true)

### Usage

Seeder allows you to quickly create dummy entries through the command line. And you can just as easily remove the dummy data when you're done building the site.
With the plugin installed, running `./craft help seeder/generate` will show you which commands are available

#### Entries

Use the command below, followed by the ``sectionId`` and the number of entries you want to create (defaults to 20 if ommited). 

```Shell
./craft seeder/generate/entries 
```

### Roadmap

#### Core fields
- [x] Title
- [x] Plain text
- [x] Email
- [x] Url
- [x] Color
- [x] Date
- [x] Categories
- [x] Dropdown
- [x] Checkboxes
- [x] Radio buttons
- [x] Multi select
- [x] Assets
- [x] Matrix
- [ ] Lightswitch
- [ ] Tags
- [ ] Users